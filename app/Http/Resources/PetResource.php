<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
            'description' => $this->description,
            'birth' => $this->birth,
            'user' => UserResource::make($this->whenLoaded('user')),
            'breed' => BreedResource::make($this->whenLoaded('breed')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
            
        ];
    }
}
