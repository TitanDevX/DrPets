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
             
                foreach (config('app.available_locales') as $key => $locale) {
                    dd("type->{$key}");
                    $query->where("type->{$key}", 'like', "%{$data['type']}%");
                }
            });

        });

        $allowedRelationships = ['breed', 'user'];
    
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