<?php


namespace App\Http\Requests\Settings;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterStore extends FormRequest
{
    public function rules()
    {
        return [
            'mail_newsletter' => 'nullable',
            'mail_release' => 'nullable',
            'mail_vote' => 'nullable',
        ];
    }

}
