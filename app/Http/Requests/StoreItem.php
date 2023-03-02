<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItem extends FormRequest
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
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'location_id', 'nullable|integer|exists:locations,id',
            'character_id', 'nullable|integer|exists:character,id',
            'item_id' => 'nullable|integer|exists:items,id',
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . auth()->user()->maxUploadSize(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'price' => 'nullable|string|max:191',
            'size' => 'nullable|string|max:191',
        ];
        $self = request()->segment(5);
        if (!empty($self)) {
            $rules['item_id'] = [
                'nullable',
                'integer',
                'not_in:' . ((int) $self),
                Rule::exists('items', 'id')->where(function ($query) use ($self) {
                    return $query->whereNull('item_id')->orWhere('item_id', '!=', $self);
                }),
            ];
        }
        return $this->clean($rules);
    }
}
