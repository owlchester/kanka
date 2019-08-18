<ul class="nav nav-tabs">
    <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
        <a href="#form-entry" title="{{ trans('crud.panels.entry') }}" data-toggle="tooltip">
            {{ trans('crud.panels.entry') }}
        </a>
    </li>
    <li>
        <a href="#form-dashboard" title="{{ trans('campaigns.panels.dashboard') }}"  data-toggle="tooltip">
            {{ trans('campaigns.panels.dashboard') }}
        </a>
    </li>
    <li>
        <a href="#form-permission" title="{{ trans('campaigns.panels.permission') }}"  data-toggle="tooltip">
            {{ trans('campaigns.panels.permission') }}
        </a>
    </li>
    <li>
        <a href="#form-public" title="{{ trans('campaigns.panels.sharing') }}"  data-toggle="tooltip">
            {{ trans('campaigns.panels.sharing') }}
        </a>
    </li>
    <li>
        <a href="#form-system" title="{{ trans('campaigns.panels.systems') }}"  data-toggle="tooltip">
            {{ trans('campaigns.panels.systems') }}
        </a>
    </li>
</ul>