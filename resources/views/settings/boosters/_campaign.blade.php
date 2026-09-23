<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
$boost = isset($boost) ? $boost : $campaign->boosts->first();?>
<div class="flex rounded-2xl shadow-xs hover:shadow-md gap-3 bg-box p-6 flex-nowrap justify-between items-center">
    <div class="flex gap-4 items-center">
        @if ($campaign->image)
            <img src="{{ $campaign->thumbnail(320, 240) }}" alt="{{ $campaign->name }}" loading="lazy" class="rounded-lg w-16 h-16" />
        @else
            <img src="https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg" alt="{{ $campaign->name }}" loading="lazy" class="rounded-lg w-16 h-16" />
        @endif
        <div class="flex flex-col">
            <a class="name text-lg font-semibold" href="{{ route('dashboard', $campaign) }}">
                {!! \Illuminate\Support\Str::limit($campaign->name, 28) !!}
            </a>

            <p class="text-neutral-content text-xs">
                @if ($campaign->premium())
                    <x-icon class="premium" />
                    {!! __('settings/boosters.campaign.premium', [
        'user' => '<a href="' . route('users.profile', $boost->user_id) . '" class="text-link">' . $boost->user->displayName() . '</a>',
        'time' => $boost->created_at->format('M Y')
        ]) !!}
                @elseif ($campaign->superboosted())
                    <x-icon class="fa-regular fa-rocket" />
                    {!! __('settings/boosters.campaign.superboosted', [
        'user' => '<a href="' . route('users.profile', $boost->user_id) . '" class="text-link">' . $boost->user->displayName() . '</a>',
        'time' => $boost->created_at->format('M Y')
        ]) !!}
                @elseif ($campaign->boosted())
                    <x-icon class="fa-regular fa-rocket" />
                    {!! __('settings/boosters.campaign.boosted', [
        'user' => '<a href="' . route('users.profile', $boost->user_id) . '" class="text-link">' . $boost->user->displayName() . '</a>',
        'time' => $boost->created_at->format('M Y')
            ]) !!}
                @else
                    {{ __('settings/boosters.campaign.standard') }} - {{ trans_choice('settings/boosters.campaign.members', $campaign->members_count, ['amount' => $campaign->members_count]) }}
                @endif
            </p>
        </div>

    </div>
    <div class="">
        @if (auth()->user()->hasLegacyBoosterNomenclature())
        <div class="dropdown">
            <a class="dropdown-toggle p-2 btn2 btn-ghost" data-dropdown aria-expanded="false" data-placement="right" data-tree="escape">
                <i class="fa-regular fa-ellipsis-h" data-tree="escape"></i>
                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
            </a>
            <div class="dropdown-menu hidden" role="menu">
                @if (!$campaign->boosted())
                    <x-dropdowns.item
                        link="#"
                        :dialog="route('campaign_boosts.create', ['campaign' => $campaign, 'boost' => 1])">
                        {!! __('settings/boosters.boost.title', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                    </x-dropdowns.item>
                    <x-dropdowns.item
                        link="#"
                        :dialog="route('campaign_boosts.create', ['campaign' => $campaign, 'superboost' => 1])">
                        {!! __('settings/boosters.superboost.title', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                    </x-dropdowns.item>
                @elseif (auth()->user()->can('destroy', $boost))
                    @if (!$campaign->superboosted())
                        <x-dropdowns.item
                            link="#"
                            :dialog="route('campaign_boosts.edit', [$boost])">
                            {!! __('settings/boosters.superboost.title', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                        </x-dropdowns.item>
                        <x-dropdowns.divider />
                        <x-dropdowns.item
                            link="#"
                            :dialog="route('campaign_boost.confirm-destroy', $boost)">
                            {!! __('settings/boosters.boost.actions.remove', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                        </x-dropdowns.item>
                    @else
                        <x-dropdowns.item
                            link="#"
                            css="text-error-content hover:bg-error"
                            :dialog="route('campaign_boost.confirm-destroy', $boost)">
                            {!! __('settings/boosters.superboost.actions.remove', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                        </x-dropdowns.item>
                    @endif
                @endif
            </div>
        </div>
        @else
            @if (!$campaign->premium())
                <a href="#" class="btn2 btn-primary" data-toggle="dialog" data-url="{{ route('campaign_boosts.create', ['campaign' => $campaign]) }}">
                    <x-icon class="premium" />
                    {!! __('settings/premium.actions.unlock', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                </a>
            @elseif (auth()->user()->can('destroy', $boost))
                <a href="#" class="btn2 btn-error btn-outline btn-sm" data-toggle="dialog" data-url="{{ route('campaign_boost.confirm-destroy', $boost) }}">
                    <x-icon class="trash" />
                    <span class="hidden lg:inline">
                    {!! __('settings/premium.actions.remove', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                    </span>
                    <span class="lg:hidden">{{ __('crud.remove') }}</span>
                </a>
            @endif
        @endif
    </div>
</div>
