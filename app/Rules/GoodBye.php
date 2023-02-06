<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class GoodBye implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Todo: mb_strtolower
        return Str::is($value, 'goodbye') || Str::is($value, 'Goodbye');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return (__('validation.goodbye', ['code' => 'goodbye']));
    }
}
