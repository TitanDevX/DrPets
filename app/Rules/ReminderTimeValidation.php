<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ReminderTimeValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {   $v = Carbon::parse($value);
        $now = Carbon::now($v->getTimezone())->addMinutes(30);
        
        if($now->isAfter($v)){
            $fail("Reminder time must be in the future!");
        }

    }
}