<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;

class StoreInventory extends UpdateInventory
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
            'item_id' => 'nullable|array|required_without:name',
            'item_id.*' => 'exists:items,id',
        ]);
    }
}
