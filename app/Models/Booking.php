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

    public function user(){
        return $this->belongsTo(User::class);
    }
   
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
