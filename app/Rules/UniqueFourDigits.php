<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueFourDigits implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = str_split($value);

        if (count($digits) !== 4) {
            $fail('The :attribute must be exactly 4 digits.');
        }

        if (count(array_unique($digits)) !== 4) {
            $fail('The :attribute must be a 4-digit number with unique digits.');
        }
    }
}
