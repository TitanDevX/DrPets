<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\User;
use App\Services\AddressService;
class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService){}

    public function index(){

        $user = auth()->user();

        return $this->res(AddressResource::make($user->address));
    }
    public function store(StoreAddressRequest $request){
        $data = $request->validated();
        $user = auth()->user();
        $data['addressable_id'] = $user->id;
        $data['addressable_type'] = User::class;
        return $this->res(AddressResource::make($this->addressService->storeAddress($data)));
    }

}