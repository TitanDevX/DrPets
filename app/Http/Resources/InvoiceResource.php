<?php

namespace App\Http\Resources;

use App\Enums\InvoiceStatus;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'status' => $this->status->name,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'fee' => $this->fee,
            'promoCode' => $this->whenLoaded('promoCode'),
            'total' => $this->total,
            'user' => UserResource::make($this->whenLoaded('user')),
            'type' => $this->type->name
            
        ];
    }
  
}
