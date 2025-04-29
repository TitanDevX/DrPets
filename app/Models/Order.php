<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    protected $casts = [
        'status' => OrderStatus::class
    ];
    protected $attributes = [
        'status' => OrderStatus::UN_PAID, // or 'pending' if string
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function orderProviders()
    {
        return $this->hasMany(OrderProvider::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }
    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'order_providers');
    }

 
}
