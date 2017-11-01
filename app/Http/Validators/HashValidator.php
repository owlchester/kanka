<?php namespace App\Http\Validators;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Validation\Validator;

class HashValidator extends Validator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return mixed
     */
    public function validateHash($attribute, $value, $parameters)
    {
        return Hash::check($value, $parameters[0]);
    }
}
