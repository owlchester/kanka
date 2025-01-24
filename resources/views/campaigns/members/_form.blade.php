<x-grid type="1/1">
    <input type="hidden" name="save_roles" value="1">
    <x-forms.field field="roles" :label="__('crud.permissions.fields.role')">
        @include('components.form.role', ['options' => [
            'multiple' => true,
            'model' => $campaignUser,
            'roles' => $roles ?? false
        ]])
    </x-forms.field>
</x-grid>
