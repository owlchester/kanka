<x-forms.field
    field="relation"
    :required="!isset($bulk)"
    :label="__('entities/relations.fields.relation')">
    {!! Form::text('relation', null, ['placeholder' => __('entities/relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</x-forms.field>
