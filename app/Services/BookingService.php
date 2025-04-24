<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\PromoCode;
use App\Models\Service;
use Date;


class BookingService
{

    public function __construct(protected InvoiceService $invoiceService,
    protected ChatService $chatService,
    protected NotificationService $notificationService){}
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

        $user = $data['user'];
        $data['date'] = Date::now();
        $booking = Booking::create($data);
        $chat = $this->chatService->openChat($user, $booking);

        return [
            'booking' => $booking,
            'chat' => $chat
        ];
    
        // $promoCode = isset($data['promo_code_id']) ? PromoCode::find($data['promo_code_id']) : null;
        // $invoice = $this->invoiceService->createInvoice($user->id, items: [
        //     'quantity' => 1,
        //      'invoicable_type' => get_class($service),
        //      'invoicable_id' => $service->id],
        // promoCode: $promoCode);


    }

    public function updateStatus(Booking $booking, BookingStatus $newStatus){

        $user = $booking->pet->user;
        $booking->update([
            'status' => $newStatus->value
        ]);

        if($newStatus == BookingStatus::ACCEPTED){


        
            $service = $booking->service;
             $invoice = $this->invoiceService->createInvoice($user->id, items: [
            'quantity' => 1,
             'invoicable_type' => get_class($service),
             'invoicable_id' => $service->id]);
             $booking->update([
                'invoice_id' => $invoice->id,
            ]);

             $this->notificationService->send($user->token, [__('notif.booking_accepted_title'), 
             __('notification.booking_accepted_body')],
            ['booking_id' => $booking->id, 'invoice_id' => $invoice->id]);
      
        
        }else if($newStatus == BookingStatus::REJECTED){
            $this->notificationService->send($user->token, [__('notif.booking_rejected_title'), 
            __('notification.booking_rejected_body')]);
   
        }else if($newStatus == BookingStatus::CANCELLED){
            $this->notificationService->send($user->token, [__('notif.booking_cancelled_title'), 
            __('notification.booking_cancelled_body')]);
        }



    }
}