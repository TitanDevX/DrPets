<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $invoicable = $this->invoicable;
        $key = class_basename($invoicable);
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            $key => $this->formatInvoiceContent()
        ];
    }
    protected function formatInvoiceContent()
{
    if (! $this->invoicable) {
        return null;
    }

    switch (get_class($this->invoicable)) {
        case \App\Models\Product::class:
            return new ProductResource($this->invoicable);
        case \App\Models\Booking::class:
            return new BookingResource($this->invoicable);
        default:
            return null;
    }
}
}
