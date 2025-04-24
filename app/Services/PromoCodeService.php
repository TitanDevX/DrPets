<?php

namespace App\Services;

use App\Models\PromoCode;


class PromoCodeService
{

   public function findByCode($code){

    return PromoCode::where('code' , '=', $code)->first();

   }


}