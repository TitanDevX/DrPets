<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\InvoiceTypeEnum;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\SiteSetting;
use Exception;
use Illuminate\Support\Facades\Log;


class InvoiceService
{
    public function __construct(protected PromoCodeService $promoCodeService,
    protected CartService $cartService,
    protected AddressService $addressService){}

    public function userInvoices($user){

        return Invoice::where('user_id' , '=', $user->id)->get();

    }
    public function handleOrderInvoiceCreation($data){
        $invoice = Invoice::findOrFail($data['invoice_id']);
        if($invoice->type == InvoiceTypeEnum::ORDER){



        }
    }
    public function applyPromocode($user, $invoiceId, $promoCode): Invoice
    {
        
        $invoice = Invoice::find($invoiceId);
        if($invoice->user_id !== $user->id){
            throw new \Exception("This invoice doesn't belong to this user!");   
        }
      
        $promo = $this->promoCodeService->findByCode($promoCode);
        if ($invoice->promo_code_id !== null) {
            throw new \Exception("A promocode has already been applied to this invoice.");
        }
        return $this->forceUpdateInvoiceWithPromoCode($invoice, $promo);
    }
    public function forceUpdateInvoiceWithPromoCode($invoice, $promoCode){
        Log::debug("INVOICE PROMO 1 " . $invoice->id . ' ' . $invoice->subtotal );
        $subtotal = $invoice->subtotal;
        $subtotal -= $subtotal * ($promoCode->value/100);
        Log::debug("INVOICE PROMO 2 " . $invoice->id . ' ' . $subtotal );
        $tax = $subtotal * ($invoice->tax/100);
        $fee = $invoice->fee;
        $total = $subtotal + $tax + $fee;
        Log::debug("INVOICE PROMO 3 " . $invoice->id . ' ' . $total );
        $invoice->update([
            'promo_code_id' => $promoCode->id,
            'total' => $total
        ]);
        Log::debug("INVOICE PROMO LAST " . $invoice->id . ' ' . $invoice->subtotal );
        return $invoice->loadMissing('promoCode');

    }

    public function storeProductsInvoice($user, $fee, $subtotal){
      
       return $this->createInvoice(InvoiceTypeEnum::ORDER,$user->id,[
        'subtotal' => $subtotal,
        'fee' => $fee]);        


    }
    /**
     * 
     * 
     * @param $data must contain: [subtotal, tax (optiona), fee (optional)]
     * 
     * 
     */
    public function createInvoice(InvoiceTypeEnum $type, int $userId, array $data = [],
    PromoCode $promoCode = null, InvoiceStatus $status = InvoiceStatus::PENDING ){
        $subtotal = $data['subtotal'];
        $subtotal = round($subtotal,2);
        $origianlSubTotal = $subtotal;
        if($promoCode != null)
            $subtotal -= $subtotal * ($promoCode->value/100);

        $taxValue = isset($data['tax']) ? $data['tax'] : SiteSetting::where('key' , '=', 'global_tax')->first()->value;
    
        $tax = $subtotal * ($taxValue/100) ;
        $fee = isset($data['fee']) ? $data['fee'] : 0;
        $fee = round($fee, 2);
       
        $total = $subtotal + $tax + $fee;
        $total = round($total,2);
       $invoice = Invoice::create(
        [
            'user_id' => $userId,
            'subtotal' => $origianlSubTotal,
            'tax' => $taxValue,
            'fee' => $fee,
            'total' => $total,
            'promo_code_id' => $promoCode == null ? null : $promoCode->id,
            'status' => $status,
            'type' => $type
        ]
        );
        
        return $invoice;


    }

 
   
}