<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class HashValidator extends Validator
{
    /**
     * @param  string  $attribute
     * @param  string  $value
     * @param  array  $parameters
     */
    public function validateHash($attribute, $value, $parameters)
    {
        return Hash::check($value, $parameters[0]);
    }
}
