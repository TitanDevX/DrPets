<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceTypeEnum;
use App\Models\Booking;
use App\Models\PromoCode;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Date;
use Illuminate\Support\Facades\Log;


class BookingService
{

    public function __construct(protected InvoiceService $invoiceService,
    protected ChatService $chatService,
    protected NotificationService $notificationService,
    protected PaymentService $paymentService,
    protected ReminderService $reminderService
    ){}
    public function all($user, $data, $paginated = true){

        $bookings = Booking::whereHas('pet.user', function ($query) use ($user) {
            $query->where('id','=',$user->id)
;        })
        ->when(isset($data['status']),function ($query) use ($data) {
           
            $query->whereIn('status', 
            array_map(fn($s) => BookingStatus::fromName($s)->value, $data['status']));
            
        });
       
       return$bookings->get();

    }

    public function book($data){
        $userId = $data['user_id'];
        $user = User::findOrFail($userId);

        $booking = Booking::create($data);
        $chat = $this->chatService->openChat($user, $booking);
        $this->reminderService->storeReminder([
            'user_id' => $userId,
            'text' => $booking->pet->name . ' ' . $booking->service->name,
            'time' => Carbon::parse($booking->date . ' ' . $booking->serviceSlot->start)
        ]);
        return [
            'booking' => $booking,
            'chat' => $chat->with('provider')->first()
        ];
    
        // $promoCode = isset($data['promo_code_id']) ? PromoCode::find($data['promo_code_id']) : null;
        // $invoice = $this->invoiceService->createInvoice($user->id, items: [
        //     'quantity' => 1,
        //      'invoicable_type' => get_class($service),
        //      'invoicable_id' => $service->id],
        // promoCode: $promoCode);


    }
    public function show($id, $withes = [])
    {
        return Booking::with($withes)->find($id);
    }

    public function cancelBooking($booking){
       
        $booking->update([
            'status' => BookingStatus::CANCELLED->value
        ]);
    
    }
    public function expirePendingBookings(){
        $bookings =Booking::where('status', 'pending')
        ->where('created_at', '<', now()->subHours(12))->get();
        foreach($bookings as $booking){
            $this->updateStatus($booking->id,BookingStatus::REJECTED );
          
        }    
    }

    public function expireAcceptedButNotPaidBookings(){
      
        $bookings = Booking::where('status', 'accepted')
        ->where(function ($query) {
            
                $query->orWhereNull('invoice_id')->orWhereHas('invoice', 
                fn($query) => $query->where('status', '!=', InvoiceStatus::PAID->value) );
        })
        ->where('accepted_at', '<', now()->subHour())->get();
    foreach($bookings as $booking){
        
        $this->updateStatus($booking->id,BookingStatus::CANCELLED );
      
    }    

    }
    public function updateStatus($bookingId, BookingStatus $newStatus){
        $booking = Booking::findOrFail($bookingId);
        if($booking->status == $newStatus) return;
        $user = $booking->pet->user;
        $booking->update([
            'status' => $newStatus->value
        ]);
        if($newStatus == BookingStatus::ACCEPTED){


        
            $service = $booking->service;
             $invoice = $this->invoiceService->createInvoice(InvoiceTypeEnum::BOOKING,$user->id,data: [
                'subtotal' => $service->price
             ]);
             $booking->update([
                'invoice_id' => $invoice->id,
                'accepted_at' => Carbon::now()
            ]);

             $this->notificationService->send($user->token, [__('notif.booking_accepted_title'), 
             __('notification.booking_accepted_body')],
            ['booking_id' => $booking->id, 'invoice_id' => $invoice->id]);
            return $invoice;
        
        }else if($newStatus == BookingStatus::REJECTED){
            $this->notificationService->send($user->token, [__('notif.booking_rejected_title'), 
            __('notification.booking_rejected_body')]);
   
        }else if($newStatus == BookingStatus::CANCELLED){
            $this->notificationService->send($user->token, [__('notif.booking_cancelled_title'), 
            __('notification.booking_cancelled_body')]);
        }


        

    }
}