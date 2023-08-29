<x-forms.field
    field="attitude"
    :label="__('entities/relations.fields.attitude')"
    :helper="__('entities/relations.hints.attitude')"
    :tooltip="true">
    {!! Form::number('attitude', null, ['placeholder' => __('entities/relations.placeholders.attitude'), 'class' => 'w-full', 'min' => -100, 'max' => 100]) !!}
</x-forms.field>
