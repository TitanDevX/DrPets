<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
class ProductController extends Controller
{
    public function __construct(protected ProductService $productService){}
    public function index(){

        $data = request()->all();
        return ProductResource::collection($this->productService->all(data: $data, withes: request()->array('withes')));
    }
}