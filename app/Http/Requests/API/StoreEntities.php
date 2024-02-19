<?php

namespace App\Http\Requests\API;

use App\Facades\Limit;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntities extends FormRequest
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

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entities' => 'array|max:20',
            'entities.*.module' => 'required|integer|exists:entity_types,id',
            'entities.*.name' => 'required|string',
            'entities.*.entry' => 'nullable|string',
            'entities.*.type' => 'nullable|string|max:191',
            'entities.*.tags' => 'array',
            'entities.*.tags.*' => 'distinct|exists:tags,id',
        ];
    }
}
