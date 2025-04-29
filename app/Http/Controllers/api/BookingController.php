<?php

namespace App\Http\Controllers\api;
use App\Enums\BookingStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ChatResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Provider;
use App\Services\BookingService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService,
    protected PaymentService $paymentService){}

    public function index(){


        $user = auth()->user();
        $bookings = $this->bookingService->all($user, request()->all());

        return $this->res(BookingResource::collection($bookings));
    }
    public function store(BookRequest $request){
        $data = $request->afterValidation();
        
        $retu = $this->bookingService->book($data);
        
        return $this->res(
            ['booking' => BookingResource::make($retu['booking']), 'chat' =>
             ChatResource::make($retu['chat']),'Booking created and a chat with service provider has been opened, pending provider approval and payment for booking to be submitted.']
        );
    }
    public function testAcceptBooking(Request $request){
        $data = Validator::make($request->all(), [
            'booking_id' => ['required', 'exists:bookings,id']
        ])->validated();

    
        $invoice = $this->bookingService->updateStatus($data['booking_id'],BookingStatus::ACCEPTED);
        return $this->res(InvoiceResource::make($invoice));
    }
    public function testDeliver(Request $request){
        $data = Validator::make($request->all(), [
            'order_id' => ['required', 'exists:orders,id'],
            'provider_id' => ['required', 'exists:providers,id']
        ])->validated();

    
        $order = Order::findOrFail($data['order_id']);
        $provider = Provider::findOr($data['provider_id']);
        $orderService = resolve(OrderService::class);
        $orderService->updateProviderStatus($provider,$order, OrderStatus::DELIVERED);
        return $this->res();
    }
    public function cancel($id){

        $booking = $this->bookingService->show($id);
        if($booking->status == BookingStatus::CANCELLED){
            return $this->res([],'Booking already cancelled.',404);
        }
        if($booking->status == BookingStatus::COMPLETED){
            
            return $this->res([],'Booking already completed.',404);
        }
        $this->bookingService->cancelBooking($booking);
        
        if($booking->invoice_id){
            $this->paymentService->refundInvoice($booking->invoice, "booking cancel");
            return $this->res([],'Booking ' . $id . ' cancelled and payment(s) refunded.');
        }
        return $this->res([],"Booking %{$id}% cancelled.");
    }
}