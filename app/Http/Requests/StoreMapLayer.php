<?php

namespace App\Http\Requests;

use App\Facades\Domain;
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
            'name' => 'required|string|max:191',
            'entry' => 'nullable',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'image_uuid' => 'required|exists:images,id',
            'position' => 'nullable|string|max:3',
            'type_id' => 'nullable|integer',
        ];

        $mapLayer = request()->route('map_layer');
        if ($mapLayer && ! empty($mapLayer->image_path)) {
            unset($rules['image_uuid']);
            if ((Domain::isApi() || request()->is('api/*')) && request()->exists('image_uuid')) {
                $rules['image_uuid'] = 'nullable|exists:images,id';
            }
        }

        return $this->clean($rules);
    }
}
