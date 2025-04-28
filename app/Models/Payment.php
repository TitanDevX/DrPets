<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => PaymentStatusEnum::class
    ];
    protected $attributes = [
        'status' => PaymentStatusEnum::PENDING, // or 'pending' if string
    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
