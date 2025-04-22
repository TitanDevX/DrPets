<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;

class AddressPolicy
{
   
    public function viewAny(User $user){
        return $user->hasPermissionTo('address.reterive');
    }
    public function update(User $user, Address $address){
        return $user->hasPermissionTo('address.update') || ($address->addressable->is($user));
    }
    public function delete(User $user, Address $address){
        return $user->hasPermissionTo('address.delete') || ($address->addressable->is($user));
    }
}
