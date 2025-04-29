<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProvider extends Pivot
{
        /** @use HasFactory<\Database\Factories\OrderProductFactory> */
        use HasFactory;


        public $table = "order_providers";
        protected $guarded = ['id', 'updated_at', 'created_at'];
    
        public function order(){
            return $this->belongsTo(Order::class);
        }
   
}
