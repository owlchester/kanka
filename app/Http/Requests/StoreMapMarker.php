<?php


namespace App\Http\Requests;


use App\Http\Resources\ApiExclusion;
use Illuminate\Foundation\Http\FormRequest;

class StoreMapMarker extends FormRequest
{
    use ApiExclusion;
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
            'name' => 'nullable|string|required_without:entity_id',
            'entry' => 'nullable|string',
            'visibility' => 'string',
            'entity_id' => 'integer|exists:entities,id|required_without:name',
            'group_id' => 'nullable|integer|exists:map_groups,id',

            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'colour' => 'max:7',
            'size_id' => 'nullable|integer',

            'shape_id' => 'required|integer',
            'custom_shape' => 'nullable|string',
            'is_draggable' => 'nullable|boolean',

            'icon' => 'required|integer',
            'custom_icon' => 'nullable|string',
        ];

        // Updating through the API? Make it easier
        $self = request()->segment(7);
//        if (!empty($self)) {
//            $rules = $this->excludeForApi(['name', 'longitude', 'latitude', 'entity_id', 'shape_id', 'icon'], $rules);
//        }

        return $rules;
    }

}
