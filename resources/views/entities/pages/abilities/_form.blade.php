<x-grid type="1/1">
    <x-helper>
        {{ __('entities/abilities.create.helper', ['name' => $entity->name]) }}
    </x-helper>
    <x-forms.field field="abilities" required >
        @include('components.form.abilities', ['options' => ['exclude-entity' => $entity->id], 'dropdownParent' => '#abilities-dialog'])
    </x-forms.field>

    @include('cruds.fields.visibility_id')
</x-grid>
