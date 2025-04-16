<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = ['invoicable_type', 'invoicable_id'];
    protected $table= "invoice_items";
    public $timestamps = false;

    public function invoicable(){
        return $this->morphTo();
    }
    public function invoice()
{
    return $this->belongsTo(Invoice::class);
}
}
