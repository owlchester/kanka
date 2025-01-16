@if (isset($campaign) && !$campaign->enabled('characters'))
    @php return @endphp
@endif

@if (!isset($preset))
    @php
    $preset = null;
    if (isset($model) && $model->character) {
        $preset = $model->character;
    } else {
        $preset = FormCopy::field('character')->child()->select();
    }
    @endphp
@endif

<x-forms.foreign
    :campaign="$campaign"
    :name="$name ?? 'character_id'"
    key="character"
    entityType="characters"
    :label="$label ?? null"
    :placeholder="$placeholder ?? null"
    :allowNew="$allowNew ?? true"
    :allowClear="$allowClear ?? true"
    :parent="$isParent ?? false"
    :route="route($route ?? 'search-list', [$campaign, config('entities.ids.character')] + (isset($model) ? ['exclude' => $model->id] : []))"
    :class="\App\Models\Character::class"
    :selected="$preset"
    :helper="$helper ?? null"
    :dropdownParent="$dropdownParent ?? null"
    :entityTypeID="config('entities.ids.character')">
</x-forms.foreign>
