<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceContent extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceContentFactory> */
    use HasFactory;
     protected $guarded = ['id'];

     public $timestamps = false;

     public function invoice(){
        return $this->belongsTo(Invoice::class);
     }
     public function invoicable(){
        return $this->morphTo('invoicable');
     }
}
