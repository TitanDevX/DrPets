<?php

namespace App\Http\Requests;

use App\Rules\ReminderTimeValidation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReminderRequest extends FormRequest
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
            'text' => [ 'max:128', 'string'],
            'time' => [new ReminderTimeValidation()],
        ];
    }
    public function afterValidation(){
        $data = $this->validated();
        if(isset($data['time'])){
        $v = Carbon::parse($data['time']);
        $data['time'] = $v->utc();
        }
        return $data;
    }
}
