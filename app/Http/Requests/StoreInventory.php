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
        return $this->clean([
            'entity_id' => 'required|exists:entities,id',
            'item_id' => 'nullable|required_without:name|exists:items,id',
            'name' => 'nullable|string|required_without:item_id',
            'amount' => 'required|numeric',
            'position' => 'nullable|string|max:191',
            'description' => 'nullable|string|max:191',
            'visibility' => 'string',
            'is_equipped' => 'boolean',
        ]);
    }
}
