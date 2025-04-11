<?php

namespace App\Http\Requests;

use App\Rules\PetUniquePerUserRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePetRequest extends FormRequest
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
            'name' => ['string', 'required','max:30', new PetUniquePerUserRule()],
            'description' => ['string', 'max:512','required'],
            'birth' => ['date',Rule::date()->todayOrBefore() ],
            'breed_id' => ['required', 'exists:breeds,id']
        ];
    }
}
