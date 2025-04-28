<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use App\Services\CartService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService,
     protected PaymentService $paymentService,
    protected CartService $cartService,

    protected OrderService $orderService){}

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
            $invoice = $this->invoiceService->applyPromocode(auth()->user(),
            $data['invoice_id'], $data['promo_code']);
            return $this->res(InvoiceResource::make($invoice));
        }catch(Exception $e){
            return $this->res(['error' => $e->getMessage()], 'error',400);
        }
    
    }

    public function pay(int $invoiceId, Request $request){
        $data = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'] 
        ])->validated();

        $data['invoice_id'] = $invoiceId;
        $payment = $this->paymentService->store($data);
            

        return $this->res(PaymentResource::make($payment));
    
    }

    public function store(Request $request){
        $user = auth()->user();
        
        if($user->address == null){

            return $this->res(message: "User must have an address set.",code: 403);
        }

        $carts = $this->cartService->all($user,paginated: false);
        $fee = $this->cartService->calculateFee($user, $carts);
        $subtotal = $this->cartService->calculateSubtotal($user, $carts);
        $invoice = $this->invoiceService->storeProductsInvoice($user, $fee, $subtotal);
        $order = $this->orderService->storeOrder($user,$carts,$invoice);
        return $this->res(InvoiceResource::make($invoice));
        
    }
}