<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;

class UpdateInventory extends StoreInventory
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
        $rules = parent::rules();
        unset($rules['item_id.*']);
        $rules['item_id'] = 'nullable|required_without:name|exists:items,id';

        return $this->clean($rules);
    }
}
