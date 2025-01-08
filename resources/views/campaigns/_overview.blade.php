<?php /** @var \App\Models\Campaign $campaign */
$boxClass = 'rounded p-5 text-center bg-box shadow-xs flex items-center justify-center gap-3 flex-col w-40 break-words';
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <x-box css="flex items-center gap-5">
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
            @if (auth()->user()->hasBoosterNomenclature()) {
                <a class="rounded border h-12 gap-2 flex items-center justify-center cursor-pointer" href="{{ route('settings.boost', ['campaign' => $campaign->id]) }}">
                    <x-icon class="fa-solid fa-angle-right" />
                    {{ __('crud.actions.enable') }}
                </a>
            @else
                <a class="rounded-full border h-12 w-12 flex gap-2 items-center justify-center cursor-pointer" href="{{ route('settings.premium', ['campaign' => $campaign->id]) }}" data-tooltip data-title="{{ __('campaigns/overview.premium.enable') }}">
                    <x-icon class="fa-solid fa-angle-right" />
                </a>
            @endif
        @elseif (auth()->check())
            <a class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer" href="{{ route('settings.premium') }}" >
                <x-icon class="fa-solid fa-angle-right" />
            </a>
        @endif
    </x-box>

    <x-box css="flex items-center gap-5">
        <div class="rounded {{ $campaign->isPublic() ? 'bg-green-200' : 'bg-neutral' }} w-12 h-12 flex items-center justify-center">
            <x-icon class="fa-solid {{ $campaign->isPublic() ? 'fa-check text-green-600' : 'fa-lock text-neutral-content' }}" />
        </div>
        <div class="flex flex-col gap-0 grow">
            <span>{!! __('crud.fields.visibility') !!}</span>
            @if ($campaign->isPublic())
                <span class="text-green-600">{!! __('campaigns/submissions.public.public') !!}</span>
            @else
                <span class="text-neutral-content">{!! __('campaigns/submissions.public.private') !!}</span>
            @endif
        </div>
        @can('update', $campaign)
        <div class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer" data-url="{{ route('campaign-visibility', [$campaign, 'from' => 'overview']) }}" data-target="primary-dialog" data-toggle="dialog-ajax">
            <x-icon class="fa-solid fa-angle-right" />
        </div>
        @endcan
    </x-box>

    @if (auth()->check() && $campaign->userIsMember())
        <x-box css="flex items-center gap-5">
            <div class="rounded bg-neutral w-12 h-12 flex items-center justify-center">
                <x-icon class="fa-solid fa-clock text-neutral-content" />
            </div>
            <div class="flex flex-col gap-0 grow">
                <span>{!! __('campaigns/overview.member.title') !!}</span>
                <span class="text-neutral-content">{!! __('users/profile.fields.member_since', ['date' => $campaign->members()->where('user_id', auth()->user()->id)->first()?->created_at->isoFormat('MMMM D, Y')]) !!}</span>
            </div>
            <div class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer" data-target="leave-confirm" data-url="{{ route('campaign.leave', $campaign) }}" data-toggle="dialog-ajax">
                <x-icon class="fa-solid fa-angle-right" />
            </div>
        </x-box>
    @endif

    @if ($campaign->isPublic())
    <x-box css="flex items-center gap-5">
        <div class="rounded w-12 h-12 flex bg-neutral items-center justify-center">
            <x-icon class="fa-solid fa-users text-neutral-content" />
        </div>
        <div class="flex flex-col gap-0 grow">
            <span>{!! __('campaigns/overview.followers.title') !!}</span>
            <span class="text-neutral-content">
                {{ trans_choice('campaigns.overview.follower-count', $campaign->follower(), ['amount' => number_format($campaign->follower())]) }}
            </span>
        </div>
    </x-box>
    @endif
</div>

{{--<div class="flex flex-wrap gap-5">--}}

{{--    <a href="#" class="{{ $boxClass }}" data-toggle="dialog"--}}
{{--         data-target="entity-count">--}}
{{--        <i class="fa-solid fa-globe fa-2x" aria-hidden="true"></i>--}}
{{--        <div class="">--}}
{{--            {{ trans_choice('campaigns.overview.entity-count', \App\Facades\CampaignCache::entityCount(), ['amount' => number_format(\App\Facades\CampaignCache::entityCount())]) }}--}}
{{--        </div>--}}
{{--    </a>--}}
{{--</div>--}}

@section('modals')
    @parent
    <x-dialog id="entity-count" :title="__('campaigns.fields.entity_count')">
        <p>
            {{ __('campaigns.helpers.entity_count_v3', ['amount' => 6]) }}
        </p>
    </x-dialog>
@endsection
