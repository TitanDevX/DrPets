<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'providers' => ProviderResource::collection($this->whenLoaded("providers")),
            'status' => $this->status,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'orderProducts' => OrderProductResource::collection($this->whenLoaded('orderProducts')),
            'orderProviders' => OrderProviderResource::collection($this->whenLoaded('orderProviders'))
        ];
    }
}
