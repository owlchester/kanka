<?php /** @var \App\Models\Campaign $model */?>

@if (!$start)
    <div class="pull-right">
        @include('cruds.fields.save', ['onlySave' => 'true', 'disableCancel' => true, 'target' => 'entity-form'])
    </div>
@endif

<ul class="nav nav-tabs">
    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
        <a href="#form-entry" title="{{ __('crud.panels.entry') }}" data-toggle="tooltip">
            {{ __('crud.panels.entry') }}
        </a>
    </li>
    <li>
        <a href="#form-dashboard" title="{{ __('campaigns.panels.dashboard') }}"  data-toggle="tooltip">
            {{ __('campaigns.panels.dashboard') }}
        </a>
    </li>
    <li>
        <a href="#form-permission" title="{{ __('campaigns.panels.permission') }}"  data-toggle="tooltip">
            {{ __('campaigns.panels.permission') }}
        </a>
    </li>
    <li>
        <a href="#form-public" title="{{ __('campaigns.panels.sharing') }}"  data-toggle="tooltip">
            {{ __('campaigns.panels.sharing') }}
        </a>
    </li>
    <li>
        <a href="#form-ui" title="{{ __('campaigns.panels.ui') }}"  data-toggle="tooltip">
            {{ __('campaigns.panels.ui') }}
        </a>
    </li>
    @if(isset($model) && $model->boosted())
    <li>
        <a href="#form-boosted" title="{{ __('campaigns.panels.boosted') }}"  data-toggle="tooltip">
            <i class="fa fa-rocket"></i> {{ __('campaigns.panels.boosted') }}
        </a>
    </li>
    @endif
{{--    <li>--}}
{{--        <a href="#form-system" title="{{ __('campaigns.panels.systems') }}"  data-toggle="tooltip">--}}
{{--            {{ __('campaigns.panels.systems') }}--}}
{{--        </a>--}}
{{--    </li>--}}
</ul>
