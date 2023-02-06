<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class CampaignDelete implements Rule
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
     * @param  string  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Str::is(mb_strtolower($value), 'delete');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return (__('validation.delete_campaign', ['code' => 'delete']));
    }
}
