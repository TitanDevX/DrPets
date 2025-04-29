<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /** @use HasFactory<\Database\Factories\RatingFactory> */
    use HasFactory;

    protected $guarded = ['id','created_at', 'deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
  
}
