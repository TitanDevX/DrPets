<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{

    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    protected $with = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function breed(){
        return $this->belongsTo(Breed::class);
    }
    public function services(){
        return $this->hasMany(Service::class);
    }
    
}
