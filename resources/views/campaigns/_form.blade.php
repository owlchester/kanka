<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
 */ ?>
@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}

<div class="panel panel-default">
    @if (!$start)
        <div class="panel-heading">
            <h4>{{ __('crud.panels.general_information') }}</h4>
        </div>
    @endif
    <div class="panel-body">
        @if ($start)
            <div class="callout callout-info">
                <h4>{{ __('campaigns.create.helper.title', ['name' => config('app.name')]) }}</h4>

                <p>{!! __('campaigns.create.helper.first') !!}</p>
                <p>{{ __('campaigns.create.helper.second') }}</p>
            </div>
        @endif
        <div class="form-group required">
            <label>{{ __('campaigns.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control']) !!}
            <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
        </div>

        @if (!$start)
        <div class="form-group">
            <label>{{ __('campaigns.fields.description') }}</label>
            {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
        </div>

        <div class="form-group">
            <label>{{ __('campaigns.fields.excerpt') }}</label>  <i class="text-muted">{{ __('campaigns.helpers.excerpt') }}</i>
            {!! Form::textarea('excerpt', null, ['class' => 'form-control html-editor', 'id' => 'excerpt']) !!}
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __('campaigns.fields.locale') }}</label>
                    {!! Form::select('locale', $languages->getSupportedLanguagesList(true), \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale(), ['class' => 'form-control']) !!}
                    <p class="help-block">{{ __('campaigns.helpers.locale') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __('campaigns.fields.system') }}</label>
                    {!! Form::text('system', null, ['placeholder' => __('campaigns.placeholders.system'), 'class' => 'form-control']) !!}
                    <p class="help-block">{!! __('campaigns.helpers.system', [
                        'link' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), ['target' => '_blank'])
                    ]) !!}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if (!$start)
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ __('campaigns.panels.permission') }}</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::hidden('entity_visibility', 0) !!}
                    <label>{{ __('campaigns.fields.entity_visibility') }}</label>
                    <div class="checkbox">
                        <label>{!! Form::checkbox('entity_visibility') !!}
                            {{ __('campaigns.entity_visibilities.private') }}
                        </label>
                    </div>
                    <p class="help-block">{{ __('campaigns.helpers.entity_visibility') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::hidden('entity_personality_visibility', 0) !!}
                    <label>{{ __('campaigns.fields.entity_personality_visibility') }}</label>
                    <div class="checkbox">
                        <label>{!! Form::checkbox('entity_personality_visibility') !!}
                            {{ __('campaigns.entity_personality_visibilities.private') }}
                        </label>
                    </div>
                    <p class="help-block">{{ __('campaigns.helpers.entity_personality_visibility') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ __('crud.panels.appearance') }}</h4>
    </div>
    <div class="panel-body">
        @include('cruds.fields.image')

        <label for="header_image">{{ __('campaigns.fields.header_image') }}</label>
        {!! Form::hidden('remove-header-image') !!}
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
                        <div class="image" style="background-image: url('{{ $model->getImageUrl(40, 'header_image') }}')" title="{{ $model->name }}">
                            <a href="#" class="img-delete" data-target="remove-header-image" title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@if (!$start && isset($model))
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ __('campaigns.panels.sharing') }}</h4>
    </div>
    <div class="panel-body">
        <div class="form-group">
            {!! Form::hidden('is_public', 0) !!}
            <label>{!! Form::checkbox('is_public') !!}
                {{ __('campaigns.visibilities.public') }}
            </label>
            <p class="help-block">{{ __('campaigns.helpers.visibility') }}<br />
                <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fas fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
            </p>
        </div>
    </div>
</div>
@endif

<div class="form-group">
    <button class="btn btn-success">{{ __('crud.save') }}</button>
    @if (!$start)
        {!! __('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    @endif
</div>
