<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\User;
use App\Services\CartService;
class CartController extends Controller
{
    public function __construct(protected CartService $cartService){}

    public function index(){
        $user = auth()->user();

        return $this->res(CartResource::collection($this->cartService->all($user)));

    }
    public function store(StoreCartRequest $request){
        $data = $request->afterValidation();

        return $this->res(CartResource::make($this->cartService->storeCart($data)));
    }
    public function show(int $id){
        $user = auth()->user();
        $cart = $this->cartService->showCart($id);
        if(!$user->can('view', $cart)){

            return $this->res(['error' => 'cannot view this cart, it doesn\'t belong to this user.'],'error',401);
        }
        return $this->res(CartResource::make($cart));
    }
    public function delete(int $id){
        $user = auth()->user();
        $cart = $this->cartService->showCart($id);
       
        if(!$user->can('delete', $cart)){

            return $this->res(['error' => 'cannot delete this cart, it doesn\'t belong to this user.'],'error',401);
        }
        $this->cartService->deleteCart($id);
        return $this->res();
    }

}