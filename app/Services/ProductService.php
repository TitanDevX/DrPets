<?php

namespace App\Services;

use App\Models\Product;


class ProductService
{
    public function all($data = [], $withes = [], $paginated = true){

        $products = Product::when(isset($data['name']), function ($query) use ($data) {
            
            return $query->where('name', 'like', "%{$data['name']}%");

        })->where(function ($query) use ($data) {
            $query->when(isset($data['minPrice']), function ($query) use ($data) {
                $query->where('price' , '>=', $data['minPrice']);
              
            });
            $query->when(isset($data['maxPrice']), function ($query) use ($data) {
                $query->where('price', '<=', $data['maxPrice']);
            });
        })->when(isset($data['category']),function ($query) use ($data) {
            $query->whereHas('category', function ($query) use ($data) {
                $query->where('name', 'like' , "$%{$data['category']}%");
            });
            
        })
        ->where(function ($query) use ($data) {
            if(!isset($data['unavailable']) || $data['unavailable'] == 'false'){
                $query->where('quantity', '>', 0);
            }
        });

       
     
       
        $allowedRelationships = ['provider', 'category'];
        if($withes != null){
        $relations = collect( $withes)
        ->intersect($allowedRelationships)
         ->all();
            $products = $products->with($relations);
        }
       
       
        if($paginated){
            return $products->paginate();
        }else{
            return $products->get();
        }
    }

}