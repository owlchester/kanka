<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMapMarker extends FormRequest
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
            'name' => 'nullable|string|required_without:entity_id',
            'entry' => 'nullable|string',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'entity_id' => 'nullable|integer|exists:entities,id|required_without:name',
            'group_id' => 'nullable|integer|exists:map_groups,id',

            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'colour' => 'max:7',
            'size_id' => 'nullable|integer',

            'shape_id' => 'required|integer',
            'custom_shape' => 'nullable|string',
            'polygon_style' => 'nullable|array',
            'polygon_style.stroke' => 'nullable|string|max:7',
            'polygon_style.stroke-width' => 'nullable|integer|min:1|max:20',
            'is_draggable' => 'boolean',
            'is_popupless' => 'boolean',
            'css' => 'nullable|string|max:45',

            'icon' => 'required|integer',
            'custom_icon' => 'nullable|string',
            'circle_radius' => 'nullable|integer|min:1',
            'opacity' => 'nullable|min:0|max:100|integer',

            'marker_size' => 'nullable|integer|min:10',
        ];

        return $this->clean($rules);
    }

    /**
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if ($key === null && is_array($data) && array_key_exists('entry', $data)) {
            $data['entry'] = $this->wrapEntryParagraphs($data['entry']);
        } elseif ($key === 'entry') {
            $data = $this->wrapEntryParagraphs($data);
        }

        return $data;
    }

    /**
     * The Tiptap map explorer sends real HTML (always starting with a tag), which needs no
     * help here; a bare-text submission (a direct API caller, not the editor) has no HTML
     * structure at all, so wrap each blank-line-separated block in its own <p> and escape any
     * literal <, >, or & the caller typed, matching every other "entry" field in the app.
     * Purify::clean() (already run by EntryObserver on every save via MapMarker's HasEntry
     * trait) is a second, redundant safety net on top.
     */
    protected function wrapEntryParagraphs(?string $text): ?string
    {
        if ($text === null || trim($text) === '') {
            return $text;
        }

        $trimmed = trim($text);

        if (str_starts_with($trimmed, '<')) {
            return $text;
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", $trimmed);
        $paragraphs = preg_split('/\n{2,}/', $normalized);

        return collect($paragraphs)
            ->map(fn ($paragraph) => '<p>' . str_replace("\n", '<br>', e(trim($paragraph))) . '</p>')
            ->implode('');
    }
}
