@include('cruds.partials.boosted')

<div class="form-group">
    <label>{{ trans('crud.fields.tooltip') }}</label>
    <p class="help-block">{{ __('crud.hints.tooltip') }}</p>
    {!! Form::textarea('entity_tooltip', $formService->prefill('tooltip', $source), ['class' => 'form-control html-editor', 'id' => 'tooltip']) !!}
    <div class="text-right">
        <a href="{{ route('helpers.link') }}" data-toggle="tooltip" title="{{ trans('helpers.link.description') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
    </div>
</div>

<div class="form-group">
    <label>{{ trans('crud.fields.entity_header') }}</label>

    {!! Form::hidden('remove-entity-header') !!}

    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                {!! Form::file('entity_header', array('class' => 'image form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::text('entity_header_url', null, ['placeholder' => trans('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

                <p class="help-block">
                    {{ trans('crud.hints.image_limitations', ['size' => auth()->user()->maxUploadSize(true)]) }}
                    @if (!auth()->user()->hasRole('patreon'))
                        <a href="{{ route('settings.patreon') }}">{{ __('crud.hints.image_patreon') }}</a>
                    @endif
                </p>
            </div>

        </div>
        <div class="col-md-2">
            @if (!empty($model->entity) && !empty($model->entity->entity_header))
                <div class="preview-v2">
                    <div class="image" style="background-image: url('{{ $model->entity->getImageUrl(false, 'entity_header') }}')" title="{{ $model->name }}">
                        <a href="#" class="img-delete" data-target="remove-entity-header" title="{{ trans('crud.remove') }}">
                            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>