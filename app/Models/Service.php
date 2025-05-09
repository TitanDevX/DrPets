<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ['id','updated_at','created_at'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function availablity(){
        return $this->hasMany(ServiceAvailability::class);
    }

    public function addresses(){
        return $this->morphMany(Address::class, 'addressable');
    }
    public function bookings(){
        return $this->hasMany(Booking::class);
    }
 
}
