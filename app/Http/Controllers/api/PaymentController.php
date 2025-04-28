<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Services\PaymentService;
use App\Services\StripeService;
use Illuminate\Http\Request;
class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService
    ,protected StripeService $stripeService){}

    public function index(){

        $user = auth()->user();

        $payments = $this->paymentService->userPayments($user);

        return $this->res(PaymentResource::collection($payments));
    }

    public function success(Request $request){
        return $this->stripeService->success($request->all());
        
    }
    public function testSuccessPay(Request $request){
        return $this->stripeService->success($request->all(), true);
    }
}