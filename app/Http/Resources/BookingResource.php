<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'invoice' => InvoiceResource::make($this->whenLoaded('invoice')),
            'service' => ServiceResource::make($this->whenLoaded('service')),
            'service_availablity_slot' => ServiceAvailablityResource::make($this->whenLoaded('serviceSlot')),
            'pet' => PetResource::make($this->whenLoaded('pet')),
            'status' => $this->status->name,
            'date' => $this->date,
        ];
    }
}
