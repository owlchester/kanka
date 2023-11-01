<x-forms.field field="bg-colour" :label=" __('maps/markers.fields.bg_colour')">
    <span>
        {!! Form::text($fieldname ?? 'colour', \App\Facades\FormCopy::field('colour')->string(), [
            'class' => 'spectrum',
            'maxlength' => 6
        ] ) !!}
    </span>
</x-forms.field>
