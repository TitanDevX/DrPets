<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService){}
}