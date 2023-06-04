<?php /** @var \App\Models\Campaign $model */?>

@if (!$start)
    <div class="pull-right">
        @include('cruds.fields.save', ['disableCopy' => true, 'disableNew' => true, 'disableCancel' => true, 'target' => 'entity-form', 'entityType' => 'campaign'])
    </div>
@endif

<ul class="nav-tabs border-none overflow-hidden">
    <li role="presentation" class="{{ (request()->get('tab') == null ? ' active' : '') }}">
        <a href="#form-entry">
            {{ __('crud.fields.entry') }}
        </a>
    </li>
    <li role="presentation">
        <a href="#form-public" >
            {{ __('campaigns.panels.sharing') }}
        </a>
    </li>
    <li role="presentation">
        <a href="#form-ui">
            {{ __('campaigns.panels.ui') }}
        </a>
    </li>
    <li role="presentation">
        <a href="#form-permission">
            {{ __('campaigns.panels.permission') }}
        </a>
    </li>
    <li role="presentation">
        <a href="#form-dashboard">
            {{ __('campaigns.panels.dashboard') }}
        </a>
    </li>
</ul>
