<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Rules\EntityFile;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityFile extends FormRequest
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
        return [
            'file' => [
                'required',
                'file',
                'max:' . Limit::upload(),
                new EntityFile,
            ],
            'name' => 'nullable|string|max:45',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
        ];
    }
}
