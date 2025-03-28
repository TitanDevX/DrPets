<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = ['id','updated_at','created_at'];

    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
}
