<label>{{ __('crud.fields.image') }}</label>
{!! Form::hidden('remove-image') !!}

<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::file('image', array('class' => 'image form-control')) !!}
        </div>
        <div class="form-group">
            {!! Form::text('image_url', null, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

            <p class="help-block">
                {{ __('crud.hints.image_limitations', ['size' => auth()->user()->maxUploadSize(true)]) }}
                @if (!auth()->user()->hasRole('patreon'))
                    <a href="{{ route('settings.patreon') }}">{{ __('crud.hints.image_patreon') }}</a>
                @endif
            </p>
        </div>

    </div>
    <div class="col-md-2">
        @if (!empty($model->image))
            <div class="preview-v2">
                <div class="image" style="background-image: url('{{ $model->getImageUrl(200, 120) }}')" title="{{ $model->name }}">
                    <a href="#" class="img-delete" data-target="remove-image" title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
