<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'data' => json_decode($this->data),
            'amount' => $this->amount,
            'status' => $this->status->name,
        ];
    }
}
