<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAvailability extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceAvailabilityFactory> */
    use HasFactory;


    protected $guarded = ['id'];
    public $timestamps = false;
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
