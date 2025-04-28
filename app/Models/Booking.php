<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    protected $casts = [
        'status' => BookingStatus::class
    ];

    protected $attributes = [
        'status' => BookingStatus::PENDING, // or 'pending' if string
    ];
    public function pet(){
        return $this->belongsTo(Pet::class);
    }
   
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function serviceSlot(){
        return $this->belongsTo(ServiceAvailability::class);
    }
    public function getPrice(){
        return $this->service->price;
    }
    
}
