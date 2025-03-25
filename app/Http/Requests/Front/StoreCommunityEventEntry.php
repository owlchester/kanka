<?php

namespace App\Http\Requests\Front;

use App\Rules\EntityLink;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommunityEventEntry extends FormRequest
{
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
            'link' => ['required', 'url', new EntityLink],
            'comment' => 'nullable|string',
        ];
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();

        return $url->previous() . '#event-form';
    }
}
