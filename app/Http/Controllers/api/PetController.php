<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use App\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PetController extends Controller
{

   
    public function __construct(protected PetService $petService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return PetResource::collection($this->petService->getPets($user, 
        request(), request()->array('withes'), false));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $data = $request->validated();

        $pet = $this->petService->storePet($data);
        return $this->res(PetResource::make($pet));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pet = Pet::find($id)->first();
        if(!$pet){
            return $this->res(['No pet with such id.'],'notfound',404);
        }
       
        
        Gate::authorize('view', $pet);
        return $this->res(PetResource::make($pet));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, int $id)
    {
        $pet = Pet::find($id);
        $data = $request->validated();
        Gate::authorize('update', $pet);

        if(!$this->petService->updatePet($pet, $data)){
            return $this->res([],'error',404);
        }
        return $this->res(PetResource::make($pet));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pet::find($id)->delete();

        return $this->res();
    }
}
