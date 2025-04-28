<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\InvoiceTypeEnum;
use App\Models\Booking;
use App\Models\PromoCode;
use App\Models\Service;
use App\Models\User;
use Date;


class BookingService
{

    public function __construct(protected InvoiceService $invoiceService,
    protected ChatService $chatService,
    protected NotificationService $notificationService,
    protected PaymentService $paymentService,
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

    public function updateStatus($bookingId, BookingStatus $newStatus){

        $booking = Booking::findOrFail($bookingId);
        if($booking->status == $newStatus) return;
        $user = $booking->pet->user;
        $booking->update([
            'status' => $newStatus->value
        ]);

        if($newStatus == BookingStatus::ACCEPTED){


        
            $service = $booking->service;
             $invoice = $this->invoiceService->createInvoice(InvoiceTypeEnum::BOOKING,$user->id, items: [[
            'quantity' => 1,
             'invoicable_type' => get_class($booking),
             'invoicable_id' => $booking->id]]);
             $booking->update([
                'invoice_id' => $invoice->id,
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