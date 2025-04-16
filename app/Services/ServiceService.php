<?php
namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
        });

        $services = $services->with(['availablity' => function (Builder $query)  {

            $query->whereDoesntHave('bookings', function ($bookingQuery) {
                $bookingQuery
                    ->where('bookings.status','=', 
                    BookingStatus::ACCEPTED->value);
            });
         
        }]);
        $allowedRelationships = ['provider', 'category'];
    
        
        if($withes != null){
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