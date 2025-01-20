{{ csrf_field() }}

<x-grid>
@if(!isset($entityAsset))

    <x-forms.field
        field="files[]"
        css="col-span-2"
        required
        :label="__('entities/files.fields.files')">
        <input type="file" multiple accept="image/*, .pdf, .gif, .webp, .pdf, .xls, .xlsx, .csv, .mp3, .ogg, .json" name="files[]" class="image w-full" id="file_{{ rand() }}" />

        <p class="text-neutral-content m-0">
            {{ __('crud.files.hints.limitations', ['formats' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), csv, mp3, ogg, json', 'size' => Limit::readable()->upload()]) }}
            @include('cruds.fields.helpers.share', ['max' => 25])
        </p>
    </x-forms.field>
@endif

    <x-forms.field
        field="file"
        css="col-span-2"
        :required="isset($entityAsset)"
        :label="__('entities/files.fields.name')">
        <input type="text" name="name" value="{!! htmlspecialchars(old('name', $entityAsset->name ?? null)) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities/files.fields.name') }}" />
    </x-forms.field>

    @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])

    @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
</x-grid>


