<x-grid>
    <x-forms.field
        field="name"
        :label="__('entities/links.fields.name')"
        :required="true">
        <input type="text" name="name" value="{!! htmlspecialchars(old('name', $entityAsset->name ?? null)) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities/links.placeholders.name') }}" />
    </x-forms.field>

    <x-forms.field
        field="url"
        :label="__('entities/links.fields.url')"
        :required="true">
        <input type="text" name="metadata[url]" value="{{ old('metadata[url]', $entityAsset->metadata['url'] ?? null) }}" maxlength="255" class="w-full" placeholder="{{ __('entities/links.placeholders.url') }}" />
    </x-forms.field>

    @include('cruds.fields.icon', ['iconFieldName' => 'metadata[icon]', 'placeholder' => 'fa-brands fa-d-and-d-beyond, ra ra-aura', 'model' => $entityAsset ?? null])
    @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
</x-grid>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_LINK }}" />
