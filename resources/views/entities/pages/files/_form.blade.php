{{ csrf_field() }}

<x-grid>
@if(!isset($entityAsset))

    <x-forms.field
        field="file"
        css="col-span-2"
        :required="true"
        :label="__('entities/files.fields.file')">
        <input type="file" name="file" class="image w-full" id="file_{{ rand() }}" accept="" />

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
        :label="__('entities/files.fields.file')">
        {!! Form::text(
            'name',
            null,
            [
                'class' => '',
                'maxlength' => 45
            ]
        ) !!}
    </x-forms.field>

    @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])

    @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
</x-grid>


