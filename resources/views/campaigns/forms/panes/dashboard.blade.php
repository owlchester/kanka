<div class="tab-pane" id="form-dashboard">
    <div class="form-group">
        <label>{{ __('campaigns.fields.excerpt') }}</label>
        {!! Form::textarea('excerptForEdition', null, ['class' => 'form-control html-editor', 'id' => 'excerpt', 'name' => 'excerpt']) !!}
        <p class="help-block">{{ __('campaigns.helpers.excerpt') }}</p>
    </div>

    <label for="header_image">{{ __('campaigns.fields.header_image') }}</label>
    {!! Form::hidden('remove-header_image') !!}
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                {!! Form::file('header_image', ['class' => 'image form-control', 'id' => 'header_image']) !!}
            </div>
            <div class="form-group">
                {!! Form::text('header_image_url', null, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
            </div>

            <p class="help-block">
                {{ __('crud.hints.image_limitations', ['size' => auth()->user()->maxUploadSize(true)]) }}
                @if (!auth()->user()->hasRole('patreon'))
                    <a href="{{ route('settings.patreon') }}">{{ __('crud.hints.image_patreon') }}</a>
                @endif
            </p>
        </div>
        <div class="col-md-2">
            @if (!empty($model->header_image))
                <div class="preview-v2">
                    <div class="image" style="background-image: url('{{ $model->getImageUrl(200, 160, 'header_image') }}')" title="{{ $model->name }}">
                        <a href="#" class="img-delete" data-target="remove-header_image" title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
