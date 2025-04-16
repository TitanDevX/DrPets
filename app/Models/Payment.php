<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => PaymentStatusEnum::class
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
