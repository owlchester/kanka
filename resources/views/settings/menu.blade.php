<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('settings.menu.personal_settings') }}
        </h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="@if(empty($active))active @endif">
                <a href="{{ route('settings.profile') }}">
                    {{ __('settings.menu.profile') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'account')active @endif">
                <a href="{{ route('settings.account') }}">
                    {{ __('settings.menu.account') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'patreon')active @endif">
                <a href="{{ route('settings.patreon') }}">
                    <i class="fab fa-patreon"></i> {{ __('settings.menu.patreon') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'boost')active @endif">
                <a href="{{ route('settings.boost') }}">
                    <i class="fa fa-rocket"></i> {{ __('settings.menu.boost') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'layout')active @endif">
                <a href="{{ route('settings.layout') }}">
                    {{ __('settings.menu.layout') }}
                </a>
            </li>
            <li class="@if(!empty($active) && $active == 'api')active @endif">
                <a href="{{ route('settings.api') }}">
                    {{ __('settings.menu.api') }}
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('settings.menu.subscription') }}
        </h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="@if(!empty($active) && $active == 'subscription')active @endif">
                <a href="{{ route('settings.subscription') }}">
                    {{ __('settings.menu.subscription_status') }}
                </a>
            </li>
        </ul>
    </div>
</div>
