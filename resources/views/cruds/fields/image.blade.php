<label>{{ trans('crud.fields.image') }}</label>
{!! Form::hidden('remove-image') !!}

<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::file('image', array('class' => 'image form-control')) !!}
        </div>
        <div class="form-group">
            {!! Form::text('image_url', null, ['placeholder' => trans('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

            <p class="help-block">
                {{ trans('crud.hints.image_limitations', ['size' => auth()->user()->maxUploadSize(true)]) }}
                @if (!auth()->user()->hasRole('patreon'))
                    <a href="{{ route('settings.patreon') }}">{{ __('crud.hints.image_patreon') }}</a>
                @endif
            </p>
        </div>

    </div>
    <div class="col-md-2">
        @if (!empty($model->image))
            <div class="preview-v2">
                <div class="image" style="background-image: url('{{ $model->getImageUrl(false) }}')" title="{{ $model->name }}">
                    <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                        <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>