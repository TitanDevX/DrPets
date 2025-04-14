<?php
namespace App\Services;

use App\Models\Service;
use Carbon\Carbon;
class ServiceService {

    public function all($data = [], $withes = [], $paginated = true){

        $services = Service::when(isset($data['name']), function ($query) use ($data) {
            
            return $query->where('name', 'like', "%{$data['name']}%");

        })->where(function ($query) use ($data) {
            $query->when(isset($data['minPrice']), function ($query) use ($data) {
                $query->where('price' , '>=', $data['minPrice']);
              
            });
            $query->when(isset($data['maxPrice']), function ($query) use ($data) {
                $query->where('price', '<=', $data['maxPrice']);
            });
        })
        ->where(function ($query) use ($data) {
        
            $query->when(isset($data['available']) && $data['available'] == 'true',function ($query) use ($data) {
                $query->whereHas('availablity',function ($query) {
                   

                    $now = Carbon::now();
                    $query->where('day','=', $now->format('D'))
                    ->whereTime('start', '<=', $now)
                    ->whereTime('end', '>=', $now);
                    
                });
            });
        });

        $allowedRelationships = ['provider', 'category', 'availablity'];
    
        
        if($withes != null){
        // Parse and validate ?with=param
        $relations = collect( $withes)
        ->intersect($allowedRelationships)
         ->all();
            $services = $services->with($relations);
        }
       
       
        if($paginated){
            return $services->paginate();
        }else{
            return $services->get();
        }
    }

}