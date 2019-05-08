<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
 */ ?>
@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}

<div class="panel panel-default">
    <div class="panel-body">
        <div class="callout callout-info">
            <h4>{{ __('campaigns.create.helper.title', ['name' => config('app.name')]) }}</h4>

            <p>{!! __('campaigns.create.helper.first') !!}</p>
            <p>{{ __('campaigns.create.helper.second') }}</p>
        </div>
        <div class="form-group required">
            <label>{{ __('campaigns.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control']) !!}
            <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
        </div>
    </div>
</div>

<div class="form-group">
    <button class="btn btn-success">{{ __('crud.save') }}</button>
</div>
