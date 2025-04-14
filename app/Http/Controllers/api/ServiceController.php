<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(protected ServiceService $serviceService){}
    public function index(){

        $data = request()->all();
        return ServiceResource::collection($this->serviceService->all(data: $data, withes: request()->array('withes')));
    }
}
