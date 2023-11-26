<x-grid type="1/1">
    <x-helper>
        {{ __('entities/transform.panel.bulk_description') }}
    </x-helper>

    <x-forms.field field="target" :label="__('entities/transform.fields.target')">
        {!! Form::select('target', $entities, null, ['class' => 'w-full', 'required' => true]) !!}
    </x-forms.field>
</x-grid>
