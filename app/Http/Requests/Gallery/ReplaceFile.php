<?php

namespace App\Http\Requests\Gallery;

use App\Facades\Limit;
use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ReplaceFile extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Campaign $campaign */
        $campaign = $this->route('campaign');
        $limit = Limit::campaign($campaign);
        if ($this->user()) {
            $limit = $limit->user($this->user());
        }
        $types = ['jpeg', 'jpg', 'gif', 'png', 'webp', 'svg', 'woff2'];

        return [
            'file' => [
                'required',
                File::types($types),
                'max:' . $limit->upload(),
            ],
        ];
    }
}
