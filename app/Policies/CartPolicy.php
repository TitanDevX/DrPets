<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Cart $cart){
        return $cart->user_id == $user->id || $user->hasPermissionTo('carts.reterive');
    }
    public function delete(User $user, Cart $cart){
        return $cart->user_id == $user->id || $user->hasPermissionTo('carts.delete');
    }
}
