<?php
/** @var \App\Models\CampaignSubmission[] $submissions */
?>

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 lg:gap-4 xl:gap-5">
    @foreach($submissions as $application)
        <x-box css="flex items-center justify-center gap-3">
            @if ($application->user->hasAvatar())
                <div class="rounded-full h-10 w-10 cover-background flex-none" style="background-image: url('{!! $application->user->getAvatarUrl() !!}')" data-title="{{ $application->user->name }}"></div>
            @else
                <div class="rounded-full bg-base-300 h-8 w-8"></div>
            @endif
            <div class="grow flex flex-col gap-0.5 overflow-hidden">
                <p class="truncate">{!! $application->user->name !!}</p>
                <p class="text-neutral-content">{{ $application->created_at->diffForHumans() }}</p>
            </div>

            <div class="rounded-full border h-8 w-8 flex items-center justify-center flex-none cursor-pointer" data-toggle="dialog" data-target="primary-dialog" data-url="{{  route('campaign_submissions.show', [$campaign, $application])}}">
                <x-icon class="fa-solid fa-angle-right" />
            </div>
        </x-box>
    @endforeach
</div>
{!! $submissions->onEachSide(0)->links() !!}
