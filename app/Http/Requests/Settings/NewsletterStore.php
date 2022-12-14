<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterStore extends FormRequest
{
    public function rules()
    {
        return [
            'mail_release' => 'nullable',
        ];
    }

}
