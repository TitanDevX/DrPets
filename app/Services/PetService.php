<?php
namespace App\Services;
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

        $allowedRelationships = ['breed', 'user', 'services'];
    
        
        if($withes != null){
        // Parse and validate ?with=param
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

}