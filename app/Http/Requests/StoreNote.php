<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Models\Note;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreNote extends FormRequest
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
            'image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'image_url' => 'nullable|url|active_url',
            'template_id' => 'nullable',
            'note_id' => 'nullable|integer|exists:notes,id',
            'attribute' => ['array', new UniqueAttributeNames()],
        ];

        /** @var Note $self */
        $self = request()->route('note');
        if (!empty($self)) {
            $rules['note_id'] = [
                'nullable',
                'integer',
                'exists:notes,id',
                new Nested(Note::class, $self)
            ];
        }

        return $this->clean($rules);
    }
}
