<x-grid type="1/1">
    <x-helper>
        <p>{{ __('families.members.create.helper', ['name' => $model->name]) }}</p>
    </x-helper>

    @include('cruds.fields.characters', ['quickCreator' => false, 'required' => true, 'model' => null])
</x-grid>
