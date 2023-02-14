<?php /** @var \App\Models\Campaign $model */?>
<div class="tab-pane" id="form-public">

    <div class="alert alert-info">
        <p>{!! __('campaigns/public.helpers.main', [
    'public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), null, ['target' => '_blank']),
    'public-role' => link_to_route('campaign_roles.public', __('campaigns.members.roles.public'), $campaign, ['target' => '_blank'])
]) !!}</p>
        <p>
            <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fa-solid fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
        </p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{ __('campaigns.fields.public') }}
                </label>
                {!! Form::select('is_public', [0 => __('campaigns.visibilities.private'), 1 => __('campaigns.visibilities.public')], null, ['class' => 'form-control']) !!}
            </div>
            @if (isset($model) && $model->isPublic())
                <p class="help-block">
                    {!! __('campaigns.helpers.view_public', ['link' => '<a href="' . route('dashboard') . '" target="_blank">' . route('dashboard') . '</a>']) !!}
                </p>

                @if ($model->publicHasNoVisibility())
                    <div class="alert alert-warning">
                        {!! __('campaigns.helpers.public_no_visibility', [
'fix' => link_to_route('campaign_roles.public', __('crud.fix-this-issue'))
]) !!}
                    </div>
                @endif
            @endif
        </div>
    </div>


    <hr />

    <h4>{{ __('campaigns.fields.public_campaign_filters') }}</h4>


    <div class="row">
        <div class="col-md-6">
            <p>{!! __('campaigns.sharing.filters', [
        'public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), null, ['target' => '_blank'])
    ]) !!}</p>

            <div class="form-group">
                <label>{{ __('campaigns.fields.locale') }}</label>
                {!! Form::select('locale', $languages->getSupportedLanguagesList(true), null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ __('campaigns.sharing.language') }}</p>
            </div>

            <div class="form-group">
                <label>{{ __('campaigns.fields.system') }}</label>
                {!! Form::text('system', null, [
                    'placeholder' => __('campaigns.placeholders.system'),
                    'class' => 'form-control',
                    'list' => 'rpg-system-list',
                    'autocomplete' => 'off'
                ]) !!}
                <p class="help-block">{{ __('campaigns.sharing.system') }}</p>
            </div>

            <div class="hidden">
                <datalist id="rpg-system-list">
                    @foreach (__('rpg_systems.names') as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>
</div>
