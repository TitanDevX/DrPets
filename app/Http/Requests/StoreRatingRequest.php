<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
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
            'rate' => ['required', 'numeric', 'decimal:0,1'],
            'text' => ['string', 'max:64']
        ];
    }
    public function afterValidation(){
        $data = $this->validated();
        $user = auth()->user();
        $data['user_id'] = $user->id;

        return $data;
    }
}
