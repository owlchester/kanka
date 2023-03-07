<?php
/** @var App\Models\Campaign $campaign
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
$boost = isset($boost) ? $boost : $campaign->boosts->first();
$buttons = [];
if (auth()->check()) {
    if (!$campaign->superboosted() && isset($boost) && auth()->user()->can('destroy', $boost)) {
        $buttons[] = '<a href="#" data-toggle="ajax-modal" data-target="#entity-modal" data-url="' . route('campaign_boosts.edit', [$campaign, $boost]) . '" class="btn btn-block bg-maroon mb-5">
            <i class="fa-solid fa-rocket"></i> ' . __('settings/boosters.superboost.title', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) . '</a>';
    }
    if (!$campaign->boosted()) {
        $buttons[] = '<a href="' . route('settings.boost', ['campaign' => $campaign->id]) .'" class="btn btn-block bg-maroon mb-5">
            <i class="fa-solid fa-rocket"></i> ' . __('campaigns.show.actions.boost') . '</a>';
    }
    if (auth()->user()->can('update', $campaign)) {
        $buttons[] = '<a href="'. route('edit', $campaign) .'" class="btn btn-primary btn-block">
            <i class="fa-solid fa-edit" aria-hidden="true"></i> '. __('campaigns.show.actions.edit') .'</a>';
    }
    $buttons[] = '<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#leave-confirm">
            <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i> ' . __('campaigns.show.actions.leave') . '
        </button>';
    if (auth()->user()->can('roles', $campaign)) {
        $buttons[] = '<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#campaign-delete-confirm">
            <i class="fa-solid fa-trash" aria-hidden="true"></i> ' . __('campaigns.destroy.action') . '
        </button>';
    }
}
?>
@if (auth()->check() && !empty($buttons))
<div class="box box-solid">
    <div class="box-body box-profile">
        {!! implode("\n", $buttons) !!}
    </div>
</div>
@endif

    <div class="hidden-xs hidden-sm">
        <div class="box box-solid entity-submenu">
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li class="@if(empty($active) || $active == 'campaign')active @endif">
                        <a href="{{ route('overview', $campaign) }}">
                            {{ __('crud.tabs.overview') }}
                        </a>
                    </li>
                    @can('update', $campaign)
                        <li class="@if(!empty($active) && $active == 'export')active @endif">
                            <a href="{{ route('export', $campaign) }}">
                                {{ __('campaigns.show.tabs.export') }}
                            </a>
                        </li>
                    @endif
                    @can('update', $campaign)
                    <li class="@if(!empty($active) && $active == 'recovery')active @endif">
                        <a href="{{ route('recovery', $campaign) }}">
                            {{ __('campaigns.show.tabs.recovery') }}
                        </a>
                    </li>
                    @endcan
                    @can('stats', $campaign)
                        <li class="@if(!empty($active) && $active == 'stats')active @endif">
                            <a href="{{ route('stats', $campaign) }}">
                                {{ __('campaigns.show.tabs.achievements') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>

        @if (auth()->check() && (auth()->user()->can('members', $campaign) || auth()->user()->can('submissions', $campaign) || auth()->user()->can('roles', $campaign)))
        <div class="box box-solid entity-submenu">
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    @can('members', $campaign)
                        <li class="@if(!empty($active) && $active == 'users')active @endif">
                            <a href="{{ route('campaign_users.index', $campaign) }}">
                                {{ __('campaigns.show.tabs.members') }}
                            </a>
                        </li>
                    @endcan
                    @can('submissions', $campaign)
                        <li class="@if(!empty($active) && $active == 'submissions')active @endif">
                            <a href="{{ route('campaign_submissions.index', $campaign) }}">
                                {{ __('campaigns.show.tabs.applications') }}
                                @if ($campaign->submissions()->count() > 0) <span class="label label-default pull-right">
                                            {{ $campaign->submissions()->count() }}
                                        </span>@endif
                            </a>
                        </li>
                    @endcan
                    @can('roles', $campaign)
                        <li class="@if(!empty($active) && $active == 'roles')active @endif">
                            <a href="{{ route('campaign_roles.index', $campaign) }}">
                                {{ __('campaigns.show.tabs.roles') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
        @endif

        <div class="box box-solid entity-submenu">
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    @can('update', $campaign)
                    <li class="@if(!empty($active) && $active == 'settings')active @endif">
                        <a href="{{ route('modules', $campaign) }}">
                            {{ __('campaigns.show.tabs.settings') }}
                        </a>
                    </li>
                    @endcan
                    @if(config('marketplace.enabled'))
                        <li class="@if (!empty($active) && $active == 'plugins')active @endif">
                            <a href="{{ route('campaign_plugins.index', $campaign) }}">
                                {{ __('campaigns.show.tabs.plugins') }}
                            </a>
                        </li>
                    @endif
                    @can('update', $campaign)
                    <li class="@if(!empty($active) && $active == 'default-images')active @endif">
                        <a href="{{ route('default-images', $campaign) }}">
                            {{ __('campaigns.show.tabs.default-images') }}
                        </a>
                    </li>
                    <li class="@if(!empty($active) && $active == 'styles')active @endif">
                        <a href="{{ route('campaign_styles.index', $campaign) }}">
                            {{ __('campaigns.show.tabs.styles') }}
                        </a>
                    </li>
                    <li class="@if(!empty($active) && $active == 'sidebar')active @endif">
                        <a href="{{ route('campaign-sidebar', $campaign) }}">
                            {{ __('campaigns.show.tabs.sidebar') }}
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>

    @php
    $menuOptions = [];
    $menuOptions['campaign'] = [
        'label' => __('crud.tabs.overview'),
        'route' => route('overview', $campaign)
    ];
    if (auth()->check()) {
        if (auth()->user()->can('update', $campaign)) {
            $menuOptions['export'] = [
                    'label' => __('campaigns.show.tabs.export'),
                    'route' => route('export', $campaign)
            ];
            $menuOptions['recovery'] = [
                    'label' => __('campaigns.show.tabs.recovery'),
                    'route' => route('recovery', $campaign)
            ];
        }
        if (auth()->user()->can('stats', $campaign)) {
            $menuOptions['stats'] = [
                    'label' => __('campaigns.show.tabs.achievements'),
                    'route' => route('stats', $campaign)
            ];
        }
        if (auth()->user()->can('members', $campaign)) {
            $menuOptions['users'] = [
                    'label' => __('campaigns.show.tabs.members'),
                    'route' => route('campaign_users.index', $campaign)
            ];
        }
        if (auth()->user()->can('submissions', $campaign)) {
            $menuOptions['submissions'] = [
                    'label' => __('campaigns.show.tabs.applications'),
                    'route' => route('campaign_submissions.index', $campaign)
            ];
        }
        if (auth()->user()->can('roles', $campaign)) {
            $menuOptions['roles'] = [
                    'label' => __('campaigns.show.tabs.roles'),
                    'route' => route('campaign_roles.index', $campaign)
            ];
        }

        if (auth()->user()->can('update', $campaign)) {
            $menuOptions['settings'] = [
                'label' => __('campaigns.show.tabs.settings'),
                'route' => route('modules', $campaign)
            ];
            $menuOptions['default-images'] = [
                'label' => __('campaigns.show.tabs.default-images'),
                'route' => route('default-images', $campaign)
            ];
            $menuOptions['styles'] = [
                'label' => __('campaigns.show.tabs.styles'),
                'route' => route('campaign_styles.index', $campaign)
            ];
            $menuOptions['sidebar'] = [
                'label' => __('campaigns.show.tabs.sidebar'),
                'route' => route('campaign-sidebar', $campaign)
            ];
        }
    }

    if (config('marketplace.enabled')) {
        $menuOptions['plugins'] = [
            'label' => __('campaigns.show.tabs.plugins'),
            'route' => route('campaign_plugins.index', $campaign)
        ];
    }
    @endphp
    <div class="hidden-md hidden-lg" id="sm-a">
        <div class="form-group">
            <select name="menu-switcher" class="form-control submenu-switcher">
                @foreach ($menuOptions as $key => $option)
                    <option name="{{ $key }}" data-route="{{ $option['route'] }}" @if($key == $active) selected="selected" @endif>
                        {{ $option['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>


@section('modals')
    @parent

    @if (auth()->check())
    <div class="modal fade" id="leave-confirm" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl text-center">
                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="clickModalLabel">{{ __('campaigns.leave.title') }}</h4>

                    @if(auth()->user()->can('leave', $campaign))
                        <p class="mt-5">{!! __('campaigns.leave.confirm', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}

                        {!! Form::open(['method' => 'GET', 'route' => ['leave', $campaign]]) !!}
                        <div class="py-5">
                            <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                            <button type="submit" class="btn btn-danger px-8 ml-5 rounded-full">
                                <span class="fa-solid fa-sign-out-alt"></span>
                                {{ __('campaigns.leave.confirm-button') }}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    @else
                        <p class="mt-5">{{ __('campaigns.leave.no-admin-left') }}</p>
                        <a href="{{ route('campaign_users.index', $campaign) }}" class="btn btn-default px-8 rounded-full">
                            {{ __('campaigns.leave.fix') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if (auth()->check() && auth()->user()->can('roles', $campaign))
        <div class="modal fade" id="campaign-delete-confirm" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-2xl text-center">
                    <div class="modal-body">

                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="clickModalLabel">{{ __('campaigns.destroy.title') }}</h4>

                        @if (auth()->user()->can('delete', $campaign))
                            <p class="mt-5">{!! __('campaigns.destroy.confirm', ['campaign' => '<strong>' . $campaign->name . '</strong>']) !!}
                            <p class="help-block"> {!! __('campaigns.destroy.hint', ['code' => '<code>delete</code>']) !!} </p>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['destroy', $campaign]]) !!}
                            <div class="form-group required">
                                {!! Form::text('delete', null, ['class' => 'form-control', 'required', 'id' => 'campaign-delete-form']) !!}
                            </div>
                            <div class="py-5">
                                <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                                <button type="submit" class="btn btn-danger px-8 ml-5 rounded-full">
                                    <span class="fa-solid fa-sign-out-alt"></span>
                                    {{ __('campaigns.destroy.confirm-button') }}
                                </button>
                            </div>
                            {!! Form::close() !!}
                        @else
                            <p class="mt-5">{{ __('campaigns.destroy.helper-v2') }}</p>
                            <a href="{{ route('campaign_users.index', $campaign) }}" class="btn btn-default px-8 rounded-full">
                                {{ __('campaigns.leave.fix') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
