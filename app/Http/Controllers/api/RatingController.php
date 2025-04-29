<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Services\RatingService;
class RatingController extends Controller
{
    public function __construct(protected RatingService $ratingService){}

    public function index(){
        $ratings = $this->ratingService->all(request()->all(), paginated: true);
        return $this->res(RatingResource::collection($ratings));
    }
    public function store(StoreRatingRequest $request){

        $data = $request->afterValidation();
        $user = auth()->user();
        if($user->cannot('create', Rating::class)){
            return $this->res([],'User reached rating limit.',403);
        }

        $rating = $this->ratingService->storeRating($data);
        return $this->res(RatingResource::make($rating));
    }

    public function show($id){
        $rating = $this->ratingService->viewRating($id);

        return $this->res(RatingResource::make($rating));
    }
    public function delete($id){
        $user = auth()->user();
        $rating = $this->ratingService->viewRating($id);
        if($user->cannot('delete', $rating)){
            return $this->res([],'No permission.', 403);
        }
        $this->ratingService->deleteRating($id);
        return $this->res();
    }
}