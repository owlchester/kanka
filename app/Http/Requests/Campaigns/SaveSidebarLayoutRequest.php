<?php

namespace App\Http\Requests\Campaigns;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSidebarLayoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $campaign = $this->route('campaign');

        return $campaign instanceof Campaign && $campaign->boosted()
            && $this->user()?->can('update', $campaign) && $this->user()?->can('admin', $campaign);
    }

    public function rules(): array
    {
        $campaign = $this->route('campaign');

        return [
            'action' => ['required', Rule::in(app()->isLocal() ? ['save', 'start', 'reset', 'legacy', 'resume'] : ['save', 'start', 'reset', 'resume'])],
            'target' => ['required', 'string', Rule::in(array_merge(['default'], $campaign->roles()->pluck('id')->map(fn ($id) => (string) $id)->all()))],
            'revision' => ['required', 'string', 'size:64'],
            'items' => ['required_if:action,save', 'array', 'list', 'max:500'],
            'items.*' => ['array:id,label,label_key,children'],
            'items.*.id' => ['required', 'string', 'max:100'],
            'items.*.label' => ['nullable', 'string', 'max:90'],
            'items.*.label_key' => ['nullable', Rule::in(['sidebar.world', 'sidebar.time', 'sidebar.game', 'sidebar.other', 'entities.bookmarks'])],
            'items.*.children' => ['sometimes', 'array', 'list', 'max:500'],
            'items.*.children.*' => ['array:id'],
            'items.*.children.*.id' => ['required', 'string', 'max:100'],
        ];
    }
}
