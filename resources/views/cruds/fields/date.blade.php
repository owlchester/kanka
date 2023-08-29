<x-forms.field field="date" :label="__('quests.fields.date')">
    {!! Form::date('date', FormCopy::field('date')->string(), ['class' => 'w-full date-picker']) !!}
</x-forms.field>
