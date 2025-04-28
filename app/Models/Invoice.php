<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at', 'deleted_at'];

    protected $casts = [
        'status' => InvoiceStatus::class,
        'type' => InvoiceTypeEnum::class,
    ];
    protected $attributes = [
        'status' => InvoiceStatus::PENDING, // or 'pending' if string
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function promoCode(){
        return $this->belongsTo(PromoCode::class);
    }
   
    public function booking(){
        return $this->hasOne(Booking::class);
    }
    public function order(){
        return $this->hasOne(Order::class);
    }
   
    
}
