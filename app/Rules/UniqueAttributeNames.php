<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueAttributeNames implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $attributes = [];
        if (is_array($value)) {
            $attributes = $value;
        } else {
            foreach ($value as $att) {
                $attributes[] = json_decode($att, true);
            }
        }

        $names = array_column($attributes, 'name');
        if (! (count($names) === count(array_flip($names)))) {
            $fail(__('validation.attribute_unique'));
        }
    }
}
