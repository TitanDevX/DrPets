<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){}

    public function index(){

        $user = auth()->user();
        return $this->res(OrderResource::collection($this->orderService->all($user,withes: [
        'orderProducts','orderProviders'])));
    }


}