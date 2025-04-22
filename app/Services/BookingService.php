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
    protected ChatService $chatService){}
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

    public function updateStatus($booking, BookingStatus $newStatus){

        $booking->update([
            'status' => $newStatus->value
        ]);
        if($newStatus == BookingStatus::ACCEPTED){
            
        }



    }
}