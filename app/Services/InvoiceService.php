<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PromoCode;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;


class InvoiceService
{


    /**
     * Only for programatic or admin access.
     * 
     * @param $data must contain: [tax (optiona), fee (optional)]
     * @param $items must be an array of InvoiceItems (quantity, invoicable_id, invoicable_type)
     * example: $items = [
     * ['quantity' => 3, 'invoicable_id' => 1, 'invoicable_type' => App\Models\Service]
     * ]
     * 
     */
    public function createInvoice(int $userId, array $data = [], array $items = [],
    PromoCode $promoCode = null, InvoiceStatus $status = InvoiceStatus::PENDING ){
        $subtotal = 0;
        foreach($items as $item){
            $invoicable = $item['invoicable_type']::find($item['invoicable_id']);
            if($invoicable == null){

                Log::debug('Invoicable with type ' . $item['invoicable_type'] . ' and id ' . $item['invoicable_id'] . ' doesnt exist');
                continue;
            }
            $subtotal += $invoicable->price * $item['quantity'];
        }
        $origianlSubTotal = $subtotal;
        if($promoCode != null)
            $subtotal -= $subtotal * ($promoCode->value/100);
        $taxValue = isset($data['tax']) ? $data['tax'] : SiteSetting::where('key' , '=', 'sitesettings.tax')->first()->value;
    
        $tax = $subtotal * ($taxValue/100) ;
        $fee = isset($data['fee']) ? $data['fee'] : 0;
       
        $total = $subtotal + $tax + $fee;
       $invoice = Invoice::create(
        [
            'user_id' => $userId,
            'subtotal' => $origianlSubTotal,
            'tax' => $data['tax'],
            'fee' => $data['fee'],
            'total' => $total,
            'promo_code_id' => $promoCode == null ? null : $promoCode->id,
            'status' => $status
        ]
        );
        foreach($items as $item){
            if(!$item['invoicable_type']->where('id', '=', $item['invoicable_id'])->exists()){
                continue;
            }
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'quantity' => $item['quantity'],
                'invoicable_id' => $item['invoicable_id'],
                'invoicable_type' => $item['invoicable_type']
            ]);
        }

        return $invoice;


    }

}