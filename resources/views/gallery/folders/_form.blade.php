<x-grid type="1/1">
    <x-forms.field field="name" :label="__('campaigns/gallery.fields.name')">
        <input type="text" name="name" maxlength="100" class="w-full" required value="{!! htmlspecialchars(old('name', $image->name ?? null)) !!}" />
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => null])
</x-grid>
