<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'provider' => ProviderResource::make($this->whenLoaded('provider')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'price' => $this->price,
            'quantity' => $this->quantity
        ];
    }
}
