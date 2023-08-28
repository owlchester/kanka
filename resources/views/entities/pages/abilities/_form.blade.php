<x-grid type="1/1">
    <div class="field-abilities required">
        @include('components.form.abilities', ['options' => ['exclude-entity' => $entity->id], 'dropdownParent' => '#abilities-dialog'])
    </div>

    @include('cruds.fields.visibility_id')
</x-grid>
