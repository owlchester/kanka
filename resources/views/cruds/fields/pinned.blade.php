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
    :tooltip="true"
    link="https://docs.kanka.io/en/latest/features/profile-sidebar/how-to-pin-elements.html">
    {!! Form::select('is_pinned', $pinnedOptions, !empty($model) ? $model->isPinned() : 0, ['class' => 'form-control']) !!}
</x-forms.field>
