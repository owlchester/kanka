{{ csrf_field() }}
@if(!isset($entityAsset))

    <div class="form-group required">
        <label>{{ __('entities/files.fields.file') }}</label>
        {!! Form::file('file', array('class' => 'image form-control')) !!}

        <p class="help-block">
            {{ __('crud.files.hints.limitations', ['formats' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), mp3, ogg, json', 'size' => auth()->user()->maxUploadSize(true)]) }}
            @include('cruds.fields.helpers.share', ['max' => 25])
        </p>
    </div>
@endif

<div class="form-group @if(isset($entityAsset)) required @endif">
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

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.is_pinned', ['model' => $entity ?? null, 'fieldName' => 'is_pinned'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
    </div>
</div>


