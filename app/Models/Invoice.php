<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at', 'deleted_at'];

    protected $casts = [
        'status' => InvoiceStatus::class,
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function promoCode(){
        return $this->hasOne(PromoCode::class);
    }

    
}
