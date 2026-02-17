<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreInventory extends FormRequest
{
    use ApiRequest;

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
            'entity_id' => 'required|integer|exists:entities,id',
            'name' => 'nullable|string|required_without:item_id',
            'item_id' => 'nullable|array|required_without:name',
            'item_id.*' => 'integer|exists:items,id',
            'amount' => 'required|numeric',
            'position' => 'nullable|string|max:191',
            'description' => 'nullable|string|max:191',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'image_uuid' => 'nullable|exists:images,id',
            'is_equipped' => 'boolean',
        ];
    }
}
