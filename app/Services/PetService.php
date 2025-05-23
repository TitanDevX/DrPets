<?php
namespace App\Services;

use App\Models\Pet;
class PetService {

    public function getPets($user, $data = [], $withes =[], $paginated){

        $pets = $user->pets()->when(isset($data['search']), function ($query) use ($data) {
            
            return $query->where('name', 'like', "%{$data['search']}%");

        })->when(isset($data['breed']), function ($query) use ($data) {
            
            return $query->whereHas('breed', function ($query) use ($data) {
                return $query->where('name', 'like', "%{$data['breed']}%");
            });

        })->when(isset($data['type']), function ($query) use ($data) {
            
            return $query->whereHas('breed', function ($query) use ($data) {
               // return $query->where('type', 'like', "%{$data['type']}%");
               $query->where(function ($query) use ($data) {
                foreach (config('app.available_locales') as $key => $locale) {
                    $query->orWhere("type->{$key}", 'like', "%{$data['type']}%");
                }
               });
             
               
            });

        });

        $allowedRelationships = ['breed', 'user', 'bookings','bookings.service.provider','bookings.serviceSlot'];
    
        
        if($withes != null){
        $relations = collect( $withes)
        ->intersect($allowedRelationships)
         ->all();
            $pets = $pets->with($relations);
        }
       
       
        if($paginated){
            return $pets->paginate();
        }else{
            return $pets->get();
        }


    }

    public function storePet($data){

        
        $pet = Pet::create(array_merge($data,['user_id' => auth()->id()]));

        return $pet;

    }
    public function updatePet($pet , $data){

        return $pet->update($data);

    }


}