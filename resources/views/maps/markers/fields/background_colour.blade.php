<x-forms.field field="bg-colour" :label=" __('maps/markers.fields.bg_colour')">
    <span>
        {!! Form::text($fieldname ?? 'colour', \App\Facades\FormCopy::field('colour')->string(), [
            'class' => 'spectrum',
            'maxlength' => 6,
            'data-append-to' => !isset($model) || empty($model) ? '#marker-modal' : null,
        ] ) !!}
    </span>
</x-forms.field>
