<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
 */ ?>
@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}

<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
        <div class="box no-border">
            <div class="box-header">
                <h3 class="box-title">
                    {{ __('campaigns.create.helper.title', ['name' => config('app.name')]) }}
                </h3>
            </div>
            <div class="box-body">
                <div class="callout callout-info">
                    <p>{!! nl2br(__('campaigns.create.helper.welcome')) !!}</p>
                </div>
                <div class="form-group required">
                    <label>{{ __('campaigns.fields.name') }}</label>
                    {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'require', 'minlength' => 4, 'maxlength' => 20]) !!}
                    <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
                </div>
            </div>
            <div class="box-footer text-right">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
            </div>
        </div>

    </div>
</div>
