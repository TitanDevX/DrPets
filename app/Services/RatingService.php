<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Rating;


class RatingService
{
    public function all($data, $paginated = true, $withes = []){
        $r =Rating::when(isset($data['user_id']), function ($query) use ($data) {
            $query->where('user_id', '=', $data['user_id']);
        });
        $allowedRelationships = ['user', 'rateable'];
    
        
        if($withes != null){
        $relations = collect( $withes)
        ->intersect($allowedRelationships)
         ->all();
            $r = $r->with($relations);
        }
        if($paginated){
            return $r->paginate();
        } else{
            return $r->get();
        }
   
    }
    public function getUserRatingCount($userId){
        
        return Rating::where('user_id', '=' , $userId)->count();

    }
    public function storeRating($data){
        $rating = Rating::create($data);

        return $rating;

    }
    public function viewRating($id, $withes = []){
        return Rating::find($id)->with($withes);
    }
    public function deleteRating($id){
        Rating::destroy($id);
    }
}