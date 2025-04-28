<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];


    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderProducts()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }
    public function getPrice(){
        return $this->price;
    }
  

}
