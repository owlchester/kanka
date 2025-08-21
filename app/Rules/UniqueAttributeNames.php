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
        if (!is_array($value)) {
            $fail;
            return;
        }

        $attributes = [];
        if (is_array(reset($value))) {
            $attributes = $value;
        } else {
            foreach ($value as $att) {
               $tempAtt = json_decode($att, true);
                if (! is_array($tempAtt)) {
                    $fail(__('entities/attributes.errors.api'));
                    return;
                }
                $attributes[] = json_decode($att, true);
            }
        }

        $names = array_column($attributes, 'name');
        if (! (count($names) === count(array_flip($names)))) {
            $fail(__('validation.attribute_unique'));
        }
    }
}
