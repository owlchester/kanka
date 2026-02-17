<?php

namespace App\Http\Requests;

use App\Models\MapLayer;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMapLayer extends FormRequest
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
        $rules = [
            'name' => 'required|max:191',
            'entry' => 'nullable',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'image_uuid' => 'required|exists:images,id',
            'position' => 'nullable|string|max:3',
            'type_id' => 'nullable|integer',
        ];

        // If editing, don't need a new image
        /** @var MapLayer $self */
        $self = request()->route('map_layer');
        if ($self && ! empty($self->image_path)) {
            unset($rules['image_uuid']);
        }

        return $this->clean($rules);
    }
}
