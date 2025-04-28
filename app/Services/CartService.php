<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Log;


class CartService
{

    public function __construct(protected AddressService $addressService){}
    public function all($user, $paginated = true, $withes = []){
        $carts =Cart::where('user_id', '=', $user->id);
        $allowedRelationships = ['product'];
    
        
        if($withes != null){
        $relations = collect( $withes)
        ->intersect($allowedRelationships)
         ->all();
            $carts = $carts->with($relations);
        }
        if($paginated){
            return $carts->paginate();
        } else{
            return $carts->get();
        }
   
    }

    public function storeCart($data){
        $cart = Cart::create($data);

        return $cart;
    }
    public function showCart($id){
        return Cart::find($id);
    }
    public function deleteCart($id){
      Cart::destroy($id);
    }

    public function groupCartsByProvider($carts, $foreach = null){
        $cartsGroupedByProviders = $carts->groupBy(fn($cart) => $cart->product->provider_id);
        if($foreach){
        $cartsGroupedByProviders->each(function ($cartss) use ($foreach)  {
            $cartss->each(function ($cart) use ($foreach)  {
                $foreach($cart);
        });
        });
        }
        return $cartsGroupedByProviders;
    }
    public function calculateFee($user, $carts){
        $fee = 0;
       $this->groupCartsByProvider($carts, function ($cart) use ($user, &$fee) {
            $provider = $cart->product->provider;
            Log::debug('NEW FEE ' . $provider->address);
            if($provider->address == null) return false;
            $fee += $provider->delivery_fee_per_km * $this->addressService->getDistanceInKm($user->address, $provider->address);
        
        });
        return $fee;
    }
    public function calculateSubtotal($user, $carts){
        $subtotal = 0;
        $carts->each(function ($cart) use ($user, &$subtotal) {
         $subtotal += $cart->product->price * $cart->quantity;
        });
        return $subtotal;
    }
}