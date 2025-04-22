<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'provider' => ProviderResource::make($this->whenLoaded('provider')),
            'pet' => PetResource::make($this->whenLoaded('pet')),
            'availablity' => ServiceAvailablityResource::collection($this->whenLoaded('availablity')),
            'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}
