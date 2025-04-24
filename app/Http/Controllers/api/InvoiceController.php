<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService){}

    public function index(){
        $user = auth()->user();

        $invoices = $this->invoiceService->userInvoices($user);

        return $this->res(InvoiceResource::collection($invoices));
    }
    public function applyPromoCode(Request $request){
        $data = Validator::make($request->all(), [
            'invoice_id' => ['required', 'exists:invoices,id'],
            'promo_code' => ['required', 'exists:promo_codes,code'] 
        ])->validated();

        try{
            $invoice = $this->invoiceService->applyPromocode($data['invoice_id'], $data['promo_code']);
            $this->res(InvoiceResource::make($invoice));
        }catch(Exception $e){
            $this->res(['error' => $e->getMessage()], 'error',400);
        }
    
    }

    public function pay(Request $request){
        $data = Validator::make($request->all(), [
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required', 'numeric'] 
        ])->validated();
        
    }
}