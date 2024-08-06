@php
    $pinnedOptions = [
        0 => __('pins.options.no'),
        1 => __('pins.options.yes')
    ];
@endphp
<x-forms.field
    field="pinned"
    :label="__('crud.fields.is_star')"
    :helper="__('crud.hints.is_star')"
    tooltip
    link="https://docs.kanka.io/en/latest/features/profile-sidebar/how-to-pin-elements.html">
    <x-forms.select name="{{ $fieldName ?? 'is_pinned' }}" :options="$pinnedOptions" :selected="isset($model) && $model->isPinned" class="w-full" />
</x-forms.field>
