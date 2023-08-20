{{ csrf_field() }}

<x-grid>
@if(!isset($entityAsset))

    <div class="field-file col-span-2 required">
        <label>{{ __('entities/files.fields.file') }}</label>
        {!! Form::file('file', array('class' => 'image form-control')) !!}

        <p class="help-block">
            {{ __('crud.files.hints.limitations', ['formats' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), mp3, ogg, json', 'size' => Limit::readable()->upload()]) }}
            @include('cruds.fields.helpers.share', ['max' => 25])
        </p>
    </div>
@endif

    <div class="field-name col-span-2 @if(isset($entityAsset)) required @endif">
        <label>{{ __('entities/files.fields.name') }}</label>
        {!! Form::text(
            'name',
            null,
            [
                'class' => 'form-control',
                'maxlength' => 45
            ]
        ) !!}
    </div>

    @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])

    @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
</x-grid>


