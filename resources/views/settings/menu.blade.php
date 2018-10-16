<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ trans('settings.menu.personal_settings') }}
        </h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="@if(empty($active))active @endif">
                <a href="{{ route('settings.profile') }}">
                    {{ trans('settings.menu.profile') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'account')active @endif">
                <a href="{{ route('settings.account') }}">
                    {{ trans('settings.menu.account') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'patreon')active @endif">
                <a href="{{ route('settings.patreon') }}">
                    {{ trans('settings.menu.patreon') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'layout')active @endif">
                <a href="{{ route('settings.layout') }}">
                    {{ trans('settings.menu.layout') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'api')active @endif">
                <a href="{{ route('settings.api') }}">
                    {{ trans('settings.menu.api') }}
                </a>
            </li>
        </ul>
    </div>
</div>