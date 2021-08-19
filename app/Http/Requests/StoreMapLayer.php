<?php


namespace App\Http\Requests;


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
            'visibility' => 'string',
            'image' => 'required_without:image_url|mimes:jpeg,png,jpg,gif,webp,svg|max:' . auth()->user()->maxUploadSize(false, 'map'),
            'image_url' => 'required_without:image|nullable|url|active_url',
            'position' => 'nullable|string|max:3',
            'type_id' => 'nullable|integer',
        ];

        // If editing, don't need a new image
        $self = request()->segment(7);
        if (!empty($self)) {
            $rules['image'] = 'nullable|mimes:jpeg,png,jpg,gif,webp,svg|max:' . auth()->user()->maxUploadSize(false, 'map');
            $rules['image_url'] = 'nullable|url|active_url';
        }

        return $this->clean($rules);
    }

}
