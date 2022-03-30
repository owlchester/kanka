<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CalendarMoonOffset implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // Max value
        $lengths = request()->get('month_length');
        if (count($lengths) === 0) {
            return false;
        }
        $max = $lengths[0];
        $min = 0 - $max;

        foreach ($value as $offset) {
            if ($offset > $max || $offset < $min) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('calendars.validators.moon_offset');
    }
}
