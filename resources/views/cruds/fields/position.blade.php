<?php
?><x-forms.field
    field="position"
    :label="__($trans . '.fields.position')"
    :helper="__($trans . '.helpers.position')">
    {!! Form::number('position', FormCopy::field('position')->string(), ['class' => 'w-full', 'maxlength' => 1]) !!}
</x-forms.field>
