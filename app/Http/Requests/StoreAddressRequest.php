<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country' => ['required','string', 'max:3'],
            'street' => ['string'],
            'city' => ['city'],
            'details' => ['string'],
            'lat' => ['required', 'decimal'],
            'long' => ['required', 'decimal'],
        ];
    }

}
