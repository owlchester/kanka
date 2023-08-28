<x-grid type="1/1">
    <p class="m-0 text-justify">{{ __('campaigns/modules.rename.helper') }}</p>

    <x-forms.field
        field="singular"
        :label="__('campaigns/modules.fields.singular')">
        {!! Form::text('singular', $singular, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => __('entities.' . $entityType->code)]) !!}
    </x-forms.field>

    <x-forms.field
        field="plural"
        :label="__('campaigns/modules.fields.plural')">
        {!! Form::text('plural', $plural, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => __('entities.' . \Illuminate\Support\Str::plural($entityType->code))]) !!}
    </x-forms.field>

    <x-forms.field
        field="icon"
        :label="__('campaigns/modules.fields.icon')">
        {!! Form::text('icon', $icon, ['class' => 'form-control', 'maxlength' => 40]) !!}
    </x-forms.field>
</x-grid>
