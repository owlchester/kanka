<?php

namespace App\Http\Requests;

use App\Facades\Domain;
use App\Facades\Limit;
use Illuminate\Foundation\Http\FormRequest;

class RecoverEntity extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'entities' => 'array',
            'entities.*' => 'distinct|exists:entities,id'
        ];

        return $rules;
    }
}
