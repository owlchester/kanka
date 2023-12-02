<x-forms.field field="font-colour" :label="__('maps/markers.fields.font_colour')">
    <span>
    {!! Form::text($fieldname ?? 'font_colour', \App\Facades\FormCopy::field('font_colour')->string(), [
        'class' => 'spectrum',
        'maxlength' => 6,
        'data-append-to' => !isset($model) || empty($model) ? '#marker-modal' : null,
    ] ) !!}
    </span>
</x-forms.field>
