<?php
namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        $user = Auth::guard('sanctum')->user();
        if($user){
            $userAddress = $user->address;

            if($userAddress){
                $lat = $userAddress->lat;
                $lng = $userAddress->long;
                $services = $services->join('addresses', function ($join) {
                    $join->on('addresses.addressable_id', '=', 'services.id')
                         ->where('addresses.addressable_type', Service::class);
                })
                ->selectRaw("services.*, 
                    MIN(
                        6371 * acos(
                            cos(radians(?)) *
                            cos(radians(addresses.lat)) *
                            cos(radians(addresses.long) - radians(?)) +
                            sin(radians(?)) *
                            sin(radians(addresses.lat))
                        )
                    ) as distance
                ", [$lat, $lng, $lat])
                ->groupBy(['services.id'])
                ->orderBy('distance');
            }
        }
       
        $allowedRelationships = ['provider', 'category', 'addresses'];
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