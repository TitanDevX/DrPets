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
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'invoicable' => $this->formatInvoiceContent()
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
        case \App\Models\Service::class:
            return new ServiceResource($this->invoicable);
        default:
            return null;
    }
}
}
