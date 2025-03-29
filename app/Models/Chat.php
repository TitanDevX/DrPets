<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /** @use HasFactory<\Database\Factories\ChatFactory> */
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function messages(){
        return $this->hasMany(ChatMessage::class);
    }
}
