<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignBoost $boost
 */
$boost = isset($boost) ? $boost : $campaign->boosts->first();?>
<div class="flex rounded-2xl gap-3 px-3 bg-box py-3 flex-nowrap">
    <div class="flex-none">
        @if ($campaign->image)
            <img src="{{ $campaign->thumbnail(60) }}" alt="{{ $campaign->name }}" loading="lazy" class="rounded-full w-12 h-12" />
        @else
            <img src="https://th.kanka.io/UngNKwPxKUPKSZ4z_Qjc9QiyeQs=/280x210/smart/src/app/backgrounds/mountain-background-medium.jpg" alt="{{ $campaign->name }}" loading="lazy" class="rounded-full w-12 h-12" />
        @endif
     </div>
    <div class="grow">
        <a class="name inline-block font-bold text-lg" href="{{ route('dashboard', $campaign) }}">
            {!! \Illuminate\Support\Str::limit($campaign->name, 28) !!}
        </a>

        <p class="mb-0">
            @if ($campaign->premium())
                {!! __('settings/boosters.campaign.premium', [
    'user' => '<a href="' . route('users.profile', $boost->user_id) . '">' . $boost->user->displayName() . '</a>',
    'time' => $boost->created_at->format('M Y')
    ]) !!}
            @elseif ($campaign->superboosted())
                {!! __('settings/boosters.campaign.superboosted', [
    'user' => '<a href="' . route('users.profile', $boost->user_id) . '">' . $boost->user->displayName() . '</a>',
    'time' => $boost->created_at->format('M Y')
    ]) !!}
            @elseif ($campaign->boosted())
                {!! __('settings/boosters.campaign.boosted', [
    'user' => '<a href="' . route('users.profile', $boost->user_id) . '">' . $boost->user->displayName() . '</a>',
    'time' => $boost->created_at->format('M Y')
        ]) !!}
            @else
                {{ __('settings/boosters.campaign.standard') }}
            @endif
        </p>
    </div>
    <div class="flex-none">
        @if (auth()->user()->hasBoosterNomenclature())
        <div class="dropdown">
            <a class="dropdown-toggle p-2" data-dropdown aria-expanded="false" data-placement="right" data-tree="escape">
                <i class="fa-solid fa-ellipsis-h" data-tree="escape"></i>
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
                            css="text-error hover:bg-error hover:text-error-content"
                            :dialog="route('campaign_boost.confirm-destroy', $boost)">
                            {!! __('settings/boosters.superboost.actions.remove', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                        </x-dropdowns.item>
                    @endif
                @endif
            </div>
        </div>
        @else
            @if (!$campaign->premium())
                <a href="#" class="btn2 btn-secondary btn-outline btn-sm" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('campaign_boosts.create', ['campaign' => $campaign]) }}">
                    {!! __('settings/premium.actions.unlock', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                </a>
            @elseif (auth()->user()->can('destroy', $boost))
                <a href="#" class="btn2 btn-error btn-outline btn-sm" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('campaign_boost.confirm-destroy', $boost) }}">
                    {!! __('settings/premium.actions.remove', ['campaign' => \Illuminate\Support\Str::limit($campaign->name, 25)]) !!}
                </a>
            @endif
        @endif
    </div>
</div>
