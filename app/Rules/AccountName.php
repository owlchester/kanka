<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class AccountName implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Str::contains($value, ['<', '>', 'https', 'http://', 'www.', 'Ђ', ' Illuro']) && Str::length($value) < 31) {
            $fail('Invalid account name.');
        }
    }
}
