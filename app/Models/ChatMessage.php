<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ChatMessageFactory> */
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];

    public function chat(){
        return $this->belongsTo(Chat::class);
    }
    public function sender(){
        return $this->morphTo('sender');
    }
}
