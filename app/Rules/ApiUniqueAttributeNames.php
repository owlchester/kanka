<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ApiUniqueAttributeNames implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $names = array_column($value, 'name');
        if (! (count($names) === count(array_flip($names)))) {
            $fail(__('validation.attribute_unique'));
        }
    }
}
