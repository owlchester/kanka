{{ csrf_field() }}
@if(!isset($entityAsset))

    <div class="form-group required">
        <label>{{ __('entities/files.fields.file') }}</label>
        {!! Form::file('file', array('class' => 'image form-control')) !!}

        <p class="help-block">
            {{ __('crud.files.hints.limitations', ['formats' => 'jpg, jpeg, png, gif, webp, pdf, xls(x), mp3, ogg, json', 'size' => auth()->user()->maxUploadSize(true)]) }}
        @if (!\App\Facades\CampaignLocalization::getCampaign()->boosted() && !auth()->user()->hasRole('patreon'))
            <br />
            <a href="{{ route('settings.subscription') }}" target="_blank">{{ __('crud.hints.image_patreon') }}</a>
        @endif
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

@include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])

