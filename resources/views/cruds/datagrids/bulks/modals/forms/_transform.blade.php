<x-grid type="1/1">
    <p class="m-0 text-neutral-content">
        {{ __('entities/transform.panel.bulk_description') }}
    </p>

    <x-forms.field field="target" :label="__('entities/transform.fields.target')">
        {!! Form::select('target', $entities, null, ['class' => 'w-full']) !!}
    </x-forms.field>
</x-grid>
