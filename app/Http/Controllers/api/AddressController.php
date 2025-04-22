<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Services\AddressService;
use Gate;
class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService){}

    public function index(){
        $user = auth()->user();
        if($user->hasPermissionTo('address.reterive')){
            $addresses = $this->addressService->all(request()->all());
            return $this->res(AddressResource::collection($addresses));
        }else{
            $address = $this->addressService->view($user->id);
            return $this->res(AddressResource::make($address));
        }
     
    }
    public function store(StoreAddressRequest $request){
        $data = $request->validated();

        $address = $this->addressService->store(auth()->user(), $data);

        return $this->res(AddressResource::make($address));

    }

}