<?php

namespace App\Services;

use App\Models\Address;
use App\Models\User;


class AddressService
{

    public function all($data = [], $withes = [], $paginated = true){

        $addresses = Address::when(
            isset($data['addressable_id']),
             fn ($query) => 
             $query->where('addressable_id', '=', $data['addressable_id']));

        $allowedRelationships = ['addressable'];
    
        
        if($withes != null){
        // Parse and validate ?with=param
        $relations = collect( $withes)
        ->intersect($allowedRelationships)
         ->all();
            $addresses = $addresses->with($relations);
        }
        if($paginated){
            return $addresses->paginate();
        }else{
            return $addresses->get();
        }
    }
    public function view($addressable_id){
        return Address::where('addressable_id', '=', $addressable_id)->first();
    }
    public function store($addressable, $data){
        if(get_class($addressable) == User::class){
            if($addressable->address()->exists){ // if user already has an address, update it instead.
               return $this->update($addressable->address, $data);
            }
        }
        $address = Address::create(array_merge($data, ['addressable_id' => $addressable->id,
        'addressable_type' => get_class($addressable)]));

        return $address;
    }

    public function update(Address $address, $data){
       $address->update($data);
       return $address;
    }
}