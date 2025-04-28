<?php

namespace App\Services;

use App\Models\Address;


class AddressService
{


    public function storeAddress($data){

        $address = Address::create($data);

        return $address;

    }

    public function getDistanceInKm($address1, $address2){
        return $this->haversine($address1->lat, $address1->long, $address2->lat, $address2->long);
    }

    /**
     * 
     *  haversine formula
     */
    private function  haversine(float $lat1, float $lon1, float $lat2, float $lon2): float {
        // Radius of Earth in kilometers
        $earthRadius = 6371.0;
    
        // Convert degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
    
        // Differences
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
    
        // Haversine formula
        $a = sin($deltaLat / 2) ** 2 +
             cos($lat1) * cos($lat2) *
             sin($deltaLon / 2) ** 2;
    
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        // Distance in kilometers
        return $earthRadius * $c;
    }
    

}