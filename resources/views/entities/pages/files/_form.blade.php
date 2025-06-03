<x-grid type="1/1">
@if(!isset($entityAsset))
    <x-helper>
        <p>{{ __('entities/files.create.helper', ['name' => $entity->name]) }}</p>
    </x-helper>

    <x-forms.field
        field="files[]"
        required
        :label="__('entities/files.fields.files')">
        <input type="file" multiple accept="image/*, .pdf, .gif, .webp, .pdf, .xls, .xlsx, .csv, .mp3, .ogg, .json" name="files[]" class="image w-full" id="file_{{ rand() }}" />

        <x-slot name="helper">
            {{ __('crud.files.hints.limitations', ['formats' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json', 'size' => Limit::readable()->upload()]) }}
            @include('cruds.fields.helpers.share', ['max' => 25])
        </x-slot>
    </x-forms.field>
@endif

    <x-forms.field
        field="file"
        :required="isset($entityAsset)"
        :label="__('entities/files.fields.name')">
        <input type="text" name="name" value="{!! htmlspecialchars(old('name', $entityAsset->name ?? null)) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities/files.fields.name') }}" data-1p-ignore="true" />
    </x-forms.field>

    <x-grid>
        @include('cruds.fields.is_pinned', ['model' => $entityAsset ?? null, 'fieldName' => 'is_pinned'])
        @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
    </x-grid>
</x-grid>



