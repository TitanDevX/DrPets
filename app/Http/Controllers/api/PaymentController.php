<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Services\PaymentService;
class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService){}

    public function index(){

        $user = auth()->user();

        $payments = $this->paymentService->userPayments($user);

        return $this->res(PaymentResource::collection($payments));
    }

}