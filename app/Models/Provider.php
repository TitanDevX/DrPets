<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarded = ['id','created_at', 'deleted_at'];

    public function address(){
        return $this->morphOne(Address::class,"adressable");
    }
}
