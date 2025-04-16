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
        })
        ->where(function ($query) use ($data) {
          
            $query->when(isset($data['available']) && $data['available'] == 'true',function ($query) use ($data) {
                $query->where(function ($query) use ($data) {

                });
                
                // $query->whereHas('availablity',function ($query) {
                   
                //     // WHERE 

                //     $now = Carbon::now();
                //     ->whereHas('bookings', function ($query) {
                //     $query->whereRaw('service_availabilities.start != bookings.time' );
                //         dd($query->toSql());
                //     });
                //     // $query->where('day','=', $now->format('D'))
                //     // ->whereTime('start', '<=', $now)
                //     // ->whereTime('end', '>=', $now);
                    
                // });
                
            });
        });

        $services = $services->with(['availablity' => function (Builder $query)  {

            $query->whereDoesntHave('bookings', function ($bookingQuery) {
                $bookingQuery
                    ->whereRaw('TIME(bookings.time) = service_availabilities.start')
                    ->whereRaw('DAYNAME(bookings.time) = service_availabilities.day')
                    ->whereNotIn('bookings.status', [BookingStatus::PENDING->value, BookingStatus::REJECTED->value]);
            });
           dd($query->toRawSql());
         
        }]);
        dd($services->first());
        foreach($services->get() as $service){
            foreach($service->availablity as $avl){



            }


        }
        $allowedRelationships = ['provider', 'category'];
    
        
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