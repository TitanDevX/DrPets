<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
            'pet_id' => ['required', 'exists:pets,id'],
            'service_id' => ['required', 'exists:services,id'],
            'service_availability_id' => ['required', 'exists:service_availabilities,id'],
            'date' => ['required', 'date']
        ];
    }

    public function afterValidation(){
        $data = $this->validated();
        $data['user_id'] = auth()->user()->id;
        return $data;
    }
}
