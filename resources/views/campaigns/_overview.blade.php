<?php /** @var \App\Models\Campaign $campaign */
$boxClass = 'rounded p-5 text-center bg-box shadow-xs flex items-center justify-center gap-3 flex-col w-40 break-words';
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <x-box class="flex items-center gap-5">
        @if ($campaign->boosted())
            @php
                $booster = $campaign->boosts()->first();
                if ($booster) {
                    $link = '<a href="' . route('users.profile', [$booster->user]) . '">' . $booster->user->name . '</a>';
                } else {
                    $link = __('crud.unknown');
                }
            @endphp
        @endif
        <div class="rounded {{ $campaign->boosted() ? 'bg-green-200' : 'bg-red-200' }} w-12 h-12 flex items-center justify-center">
            <x-icon class="fa-solid {{ $campaign->boosted() ? 'fa-gem text-green-600' : 'fa-times text-red-500' }}" />
        </div>
        <div class="flex flex-col gap-0 grow">
            <span>{!! __('campaigns.status.title') !!}</span>
            @if ($campaign->premium())
                <span class="text-green-600">
                    {!! __('campaigns.status.premium', ['name' => $link]) !!}
                </span>
            @elseif ($campaign->boosted())
                <span class="text-green-600">
                    {{ __('campaigns.fields.' . ($campaign->superboosted() ? 'superboosted' : 'boosted')) }}
                    {!! $link !!}
                </span>
            @else
                <span class="text-neutral-content">{!! __('campaigns.status.free') !!}</span>
            @endif
        </div>
        @if (!$campaign->boosted() && auth()->check())
            @if (auth()->user()->hasBoosterNomenclature())
                <a class="rounded-full border h-12 w-12 gap-2 flex items-center justify-center cursor-pointer neutral-link" href="{{ route('settings.boost', ['campaign' => $campaign->id]) }}">
                    <x-icon class="fa-solid fa-angle-right" />
                </a>
            @else
                <a class="rounded-full border h-12 w-12 flex gap-2 items-center justify-center cursor-pointer neutral-link" href="{{ route('settings.premium', ['campaign' => $campaign->id]) }}" data-tooltip data-title="{{ __('campaigns/overview.premium.enable') }}">
                    <x-icon class="fa-solid fa-angle-right" />
                </a>
            @endif
        @elseif (auth()->check())
            <a class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer neutral-link" href="{{ route('settings.premium') }}" >
                <x-icon class="fa-solid fa-angle-right" />
            </a>
        @endif
    </x-box>


    <x-infoBox
        title="{{ __('crud.fields.visibility') }}"
        icon="{{ $campaign->isPublic() ? 'fa-solid fa-check text-green-600' : 'fa-solid fa-lock text-neutral-content' }}"
        subtitle="{{ $campaign->isPublic() ? __('campaigns/submissions.public.public') : __('campaigns/submissions.public.private') }}"
        background="{{ $campaign->isPublic() ? 'bg-green-200' : 'bg-neutral' }}"
        subtitleColour="{{ $campaign->isPublic() ? 'text-green-600' : 'text-neutral-content' }}"
        :campaign="$campaign"
        :url="auth()->check() && auth()->user()->can('update', $campaign) ? route('campaign-visibility', [$campaign, 'from' => 'overview']) : null"
        :urlTooltip="__('campaigns/public.title')"
        ajax
    ></x-infoBox>

    @if (auth()->check() && $campaign->userIsMember())
        <x-infoBox
            title="{{ __('campaigns/overview.member.title') }}"
            icon="fa-solid fa-clock text-neutral-content"
            subtitle="{{ __('users/profile.fields.member_since', ['date' => $campaign->members()->where('user_id', auth()->user()->id)->first()?->created_at?->isoFormat('MMMM D, Y')]) }}"
            :campaign="$campaign"
            :url="route('campaign.leave', $campaign)"
            :urlTooltip="__('campaigns.leave.title')"
            ajax
        ></x-infoBox>
    @endif

    @if ($campaign->isPublic())
        <x-infoBox
            :title="__('campaigns/overview.followers.title')"
            icon="fa-solid fa-users text-neutral-content"
            :subtitle="trans_choice('campaigns.overview.follower-count', $campaign->follower(), ['amount' => number_format($campaign->follower())])"
        ></x-infoBox>
    @endif
</div>

