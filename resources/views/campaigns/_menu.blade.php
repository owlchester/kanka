<?php
/** @var App\Models\Campaign $campaign
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
$boost = isset($boost) ? $boost : $campaign->boosts->first();
$buttons = [];
if (auth()->check()) {
    if (auth()->user()->hasBoosterNomenclature() && !$campaign->superboosted() && isset($boost) && auth()->user()->can('destroy', $boost)) {
        $buttons[] = '<a href="#" data-toggle="ajax-modal" data-target="#entity-modal" data-url="' . route('campaign_boosts.edit', [$boost]) . '" class="btn btn-block bg-boost text-white">
            <i class="fa-solid fa-premium" aria-hidden=true"></i> ' . __('settings/boosters.superboost.title', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) . '</a>';
    }
    if (!$campaign->boosted()) {
        if (auth()->check() && auth()->user()->hasBoosterNomenclature()) {
        $buttons[] = '<a href="' . route('settings.boost', ['campaign' => $campaign->id]) .'" class="btn btn-block bg-boost text-white mb-5">
            <i class="fa-solid fa-premium" aria-hidden=true"></i> ' . __('callouts.booster.actions.boost', ['campaign' => $campaign->name]) . '</a>';
        } else {
        $buttons[] = '<a href="' . route('settings.premium', ['campaign' => $campaign->id]) .'" class="btn btn-block bg-boost text-white mb-5">
            <i class="fa-solid fa-premium" aria-hidden=true"></i> ' . __('settings/premium.actions.unlock') . '</a>';
        }
    }
    if (auth()->user()->can('update', $campaign)) {
        $buttons[] = '<a href="'. route('campaigns.edit') .'" class="btn btn-primary btn-block">
            <i class="fa-solid fa-edit" aria-hidden=true"></i> '. __('campaigns.show.actions.edit') .'</a>';
    }
    if ($campaign->userIsMember()) {
    $buttons[] = '<button type="button" class="btn btn-warning btn-block" data-toggle="dialog" data-target="leave-confirm">
            <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i> ' . __('campaigns.show.actions.leave') . '
        </button>';
    }
    if (auth()->user()->can('roles', $campaign)) {
        $buttons[] = '<button type="button" class="btn btn-danger btn-block" data-toggle="dialog" data-target="campaign-delete-confirm">
            <i class="fa-regular fa-trash" aria-hidden=true"></i> ' . __('campaigns.destroy.action') . '
        </button>';
    }
}
?>
@if (auth()->check() && !empty($buttons))
    <div class="mb-5">
        {!! implode("\n", $buttons) !!}
    </div>
@endif

    <div class="hidden lg:!block ">
        <x-box css="" :padding="0">
            <x-menu>
                <x-menu.element
                    :route="route('campaign')"
                    :active="empty($active) || $active === 'campaign'">
                    {{ __('crud.tabs.overview') }}
                </x-menu.element>
                @can('update', $campaign)
                <x-menu.element
                    :route="route('campaign.export')"
                    :active="empty($active) || $active === 'export'">
                    {{ __('campaigns.show.tabs.export') }}
                </x-menu.element>
                @endcan
                @can('update', $campaign)
                <x-menu.element
                    :active="!empty($active) && $active === 'recovery'"
                    :route="route('recovery')">
                        {{ __('campaigns.show.tabs.recovery') }}
                </x-menu.element>
                @endcan
                @can('stats', $campaign)
                    <x-menu.element
                        :active="!empty($active) && $active === 'stats'"
                        :route="route('stats')">
                        {{ __('campaigns.show.tabs.achievements') }}
                    </x-menu.element>
                @endcan
            </x-menu>
        </x-box>

        @if (auth()->check() && (auth()->user()->can('members', $campaign) || auth()->user()->can('submissions', $campaign) || auth()->user()->can('roles', $campaign)))
            <x-box css="" :padding="0">
                <x-menu>
                    @can('members', $campaign)
                        <x-menu.element
                            :active="!empty($active) && $active === 'users'"
                            :route="route('campaign_users.index')">
                            {{ __('campaigns.show.tabs.members') }}
                        </x-menu.element>
                    @endcan
                    @can('submissions', $campaign)
                            <x-menu.element
                                :active="!empty($active) && $active === 'submissions'"
                                :route="route('campaign_submissions.index')"
                                :badge="$campaign->submissions()->count()"
                            >
                                {{ __('campaigns.show.tabs.applications') }}
                            </x-menu.element>
                    @endcan
                    @can('roles', $campaign)
                        <x-menu.element
                            :active="!empty($active) && $active === 'roles'"
                            :route="route('campaign_roles.index')">
                            {{ __('campaigns.show.tabs.roles') }}
                        </x-menu.element>
                    @endcan
                </x-menu>
            </x-box>
        @endif

        <x-box css="" :padding="0">
            <x-menu>
                @can('update', $campaign)
                    <x-menu.element
                        :active="!empty($active) && $active === 'settings'"
                        :route="route('campaign.modules')">
                        {{ __('campaigns.show.tabs.settings') }}
                    </x-menu.element>
                @endcan
                @if(config('marketplace.enabled'))
                <x-menu.element
                    :active="!empty($active) && $active === 'plugins'"
                    :route="route('campaign_plugins.index')">
                    {{ __('campaigns.show.tabs.plugins') }}
                </x-menu.element>
                @endif
                @can('update', $campaign)
                <x-menu.element
                    :active="!empty($active) && $active === 'default-images'"
                    :route="route('campaign.default-images')">
                    {{ __('campaigns.show.tabs.default-images') }}
                </x-menu.element>
                <x-menu.element
                    :active="!empty($active) && $active === 'styles'"
                    :route="route('campaign_styles.index')">
                    {{ __('campaigns.show.tabs.styles') }}
                </x-menu.element>
                <x-menu.element
                    :active="!empty($active) && $active === 'sidebar'"
                    :route="route('campaign-sidebar')">
                    {{ __('campaigns.show.tabs.sidebar') }}
                </x-menu.element>
                @endcan
            </x-menu>
        </x-box>
    </div>

    @php
    $menuOptions = [];
    $menuOptions['campaign'] = [
        'label' => __('crud.tabs.overview'),
        'route' => route('campaign')
    ];
    if (auth()->check()) {
        if (auth()->user()->can('update', $campaign)) {
            $menuOptions['export'] = [
                    'label' => __('campaigns.show.tabs.export'),
                    'route' => route('campaign.export')
            ];
            $menuOptions['recovery'] = [
                    'label' => __('campaigns.show.tabs.recovery'),
                    'route' => route('recovery')
            ];
        }
        if (auth()->user()->can('stats', $campaign)) {
            $menuOptions['stats'] = [
                    'label' => __('campaigns.show.tabs.achievements'),
                    'route' => route('stats')
            ];
        }
        if (auth()->user()->can('members', $campaign)) {
            $menuOptions['users'] = [
                    'label' => __('campaigns.show.tabs.members'),
                    'route' => route('campaign_users.index')
            ];
        }
        if (auth()->user()->can('submissions', $campaign)) {
            $menuOptions['submissions'] = [
                    'label' => __('campaigns.show.tabs.applications'),
                    'route' => route('campaign_submissions.index')
            ];
        }
        if (auth()->user()->can('roles', $campaign)) {
            $menuOptions['roles'] = [
                    'label' => __('campaigns.show.tabs.roles'),
                    'route' => route('campaign_roles.index')
            ];
        }

        if (auth()->user()->can('update', $campaign)) {
            $menuOptions['settings'] = [
                'label' => __('campaigns.show.tabs.settings'),
                'route' => route('campaign.modules')
            ];
            $menuOptions['default-images'] = [
                'label' => __('campaigns.show.tabs.default-images'),
                'route' => route('campaign.default-images')
            ];
            $menuOptions['styles'] = [
                'label' => __('campaigns.show.tabs.styles'),
                'route' => route('campaign_styles.index')
            ];
            $menuOptions['sidebar'] = [
                'label' => __('campaigns.show.tabs.sidebar'),
                'route' => route('campaign-sidebar')
            ];
        }
    }

    if (config('marketplace.enabled')) {
        $menuOptions['plugins'] = [
            'label' => __('campaigns.show.tabs.plugins'),
            'route' => route('campaign_plugins.index')
        ];
    }
    @endphp
    <div class="lg:hidden" id="sm-a">
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

    @if (auth()->check() && $campaign->userIsMember())
        <x-dialog id="leave-confirm" :title="__('campaigns.leave.title')">
            @if(auth()->user()->can('leave', $campaign))
                <p class="">
                {!! __('campaigns.leave.confirm', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}
                </p>
                <div class="grid grid-cols-2 gap-2 w-full">
                    <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                        {{ __('crud.cancel') }}
                    </x-buttons.confirm>
                    {!! Form::open(['method' => 'GET', 'route' => ['campaigns.leave', $campaign->id], 'class' => 'w-full']) !!}
                    <x-buttons.confirm type="danger" outline="true" full="true">
                        <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i>
                        {{ __('campaigns.leave.confirm-button') }}
                    </x-buttons.confirm>
                    {!! Form::close() !!}
                </div>
            @else
                <p class="mt-5">{{ __('campaigns.leave.no-admin-left') }}</p>
                <a href="{{ route('campaign_users.index') }}" class="btn btn-default px-8 rounded-full">
                    {{ __('campaigns.leave.fix') }}
                </a>
            @endif
        </x-dialog>
    </div>
    @endif

    @if (auth()->check() && auth()->user()->can('roles', $campaign))
        <x-dialog id="campaign-delete-confirm" :title="__('campaigns.destroy.title')">
            @if (auth()->user()->can('delete', $campaign))
                {!! Form::open(['method' => 'DELETE', 'route' => ['campaigns.destroy']]) !!}
                <p class="mt-5">{!! __('campaigns.destroy.confirm', ['campaign' => '<strong>' . $campaign->name . '</strong>']) !!}
                <p class="help-block"> {!! __('campaigns.destroy.hint', ['code' => '<code>delete</code>']) !!} </p>

                <div class="form-group required">
                    {!! Form::text('delete', null, ['class' => 'form-control', 'required', 'id' => 'campaign-delete-form']) !!}
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                        {{ __('crud.cancel') }}
                    </x-buttons.confirm>
                    {!! Form::open(['method' => 'GET', 'route' => ['campaigns.leave', $campaign->id], 'class' => 'w-full']) !!}
                    <x-buttons.confirm type="danger" outline="true" full="true">
                        <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i>
                        {{ __('campaigns.destroy.confirm-button') }}
                    </x-buttons.confirm>
                </div>
                {!! Form::close() !!}
            @else
                <div class="max-w-lg text-justify">
                    <p class="mt-5">{{ __('campaigns.destroy.helper-v2') }}</p>
                    <a href="{{ route('campaign_users.index') }}" class="py-2">
                        {{ __('campaigns.leave.fix') }}
                    </a>
                </div>
            @endif
        </x-dialog>
    @endif
@endsection
