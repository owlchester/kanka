<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
 */ ?>
@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}

<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
        <x-box>
            <h3 class="text-lg m-0 mb-2">
                {{ __('campaigns.create.helper.title', ['name' => config('app.name')]) }}
            </h3>
            <x-alert type="info">
                <p>{!! nl2br(__('campaigns.create.helper.welcome')) !!}</p>
            </x-alert>
            <div class="form-group required">
                <label>{{ __('campaigns.fields.name') }}</label>
                {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'require', 'minlength' => 4, 'maxlength' => 191]) !!}
                <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
            </div>


            <div class="text-right">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
            </div>
        </x-box>
    </div>
</div>
