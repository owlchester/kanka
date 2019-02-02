<?php /** @var \App\Models\Campaign $model */ ?>
@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}
<div class="row">
    <div class="col-md-{{ (isset($start) ? 12 : 6) }}">
        <div class="form-group required">
            <label>{{ trans('campaigns.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('campaigns.placeholders.name'), 'class' => 'form-control']) !!}
            <p class="help-block">{{ trans('campaigns.helpers.name') }}</p>
        </div>
    </div>
</div>
    @if (!isset($start))
        <div class="row">
            <div class="col-md-6">
                @include('cruds.fields.image')
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('campaigns.fields.header_image') }}</label>
                    {!! Form::hidden('remove-header-image') !!}
                    <div class="row">
                        <div class="col-md-5">
                            {!! Form::file('header_image', array('class' => 'image form-control')) !!}
                        </div>
                        <div class="col-md-7">
                            {!! Form::text('header_image_url', null, ['placeholder' => trans('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <p class="text-muted">
                        {{ trans('crud.hints.image_limitations', ['size' => auth()->user()->maxUploadSize(true)]) }}
                        @if (!auth()->user()->hasRole('patreon'))
                            <a href="{{ route('settings.patreon') }}">{{ __('crud.hints.image_patreon') }}</a>
                        @endif
                    </p>

                    @if (!empty($model->header_image))
                        <div class="preview">
                            <div class="image">
                                <img src="{{ $model->getImageUrl(true, 'header_image') }}" alt="{{ $model->name }}"/>
                                <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                                    <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                                </a>
                            </div>
                            <br class="clear">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('campaigns.fields.locale') }}</label>
                    {!! Form::select('locale', $languages->getSupportedLanguagesList(), null, ['class' => 'form-control']) !!}
                    <p class="help-block">{{ trans('campaigns.helpers.locale') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ trans('campaigns.fields.system') }}</label>
                    {!! Form::text('system', null, ['placeholder' => __('campaigns.placeholders.system'), 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::hidden('entity_visibility', 0) !!}
                    <label>{{ trans('campaigns.fields.entity_visibility') }}</label>
                    <div class="checkbox">
                        <label>{!! Form::checkbox('entity_visibility') !!}
                            {{ trans('campaigns.entity_visibilities.private') }}
                        </label>
                    </div>
                    <p class="help-block">{{ trans('campaigns.helpers.entity_visibility') }}</p>
                </div>
            </div>
        </div>
    @endif

@if (!isset($start))
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ trans('campaigns.fields.description') }}</label>
                {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
            </div>
        </div>
    </div>

    @if (isset($model))
    <div class="form-group">
        {!! Form::hidden('is_public', 0) !!}
        <label>{!! Form::checkbox('is_public') !!}
            {{ trans('campaigns.visibilities.public') }}
        </label>
        <p class="help-block">{{ trans('campaigns.helpers.visibility') }}<br />
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fas fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
        </p>
    </div>
    @endif
@endif

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @if (!isset($start))
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    @endif
</div>
