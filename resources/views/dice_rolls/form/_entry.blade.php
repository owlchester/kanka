
<x-grid>
    @include('cruds.fields.name', ['trans' => 'dice_rolls'])
    @include('cruds.fields.character', ['name' => 'character_id'])
    @include('cruds.fields.tags')

    <x-forms.field
        field="parameters"
        :required="true"
        :label="__('dice_rolls.fields.parameters')">
        {!! Form::text('parameters', FormCopy::field('parameters')->string(), ['placeholder' => __('dice_rolls.placeholders.parameters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        <a href="//docs.kanka.io/en/latest/entities/dice-rolls.html#creating-a-dice-roll-template" target="_blank">{{ __('dice_rolls.hints.parameters') }}</a>
    </x-forms.field>
    @include('cruds.fields.image')
</x-grid>
