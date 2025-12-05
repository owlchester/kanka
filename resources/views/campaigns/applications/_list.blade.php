<?php
/** @var \App\Models\Application[] $applications */
?>

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 lg:gap-4 xl:gap-5">
    @foreach($applications as $application)
        <div class="bg-base-100 shadow-xs hover:shadow rounded-xl flex p-4 items-center justify-center gap-3">
            @if ($application->user->hasAvatar())
                <x-users.avatar :user="$application->user" class="h-10 w-10" />
            @else
                <div class="rounded-full bg-base-300 h-8 w-8"></div>
            @endif
            <div class="grow flex flex-col gap-0.5 overflow-hidden">
                <p class="truncate">{!! $application->user->name !!}</p>
                <p class="text-neutral-content">{{ $application->created_at->diffForHumans() }}</p>
            </div>

            <div class="rounded-full border h-8 w-8 flex items-center justify-center flex-none cursor-pointer" data-toggle="dialog" data-url="{{  route('applications.show', [$campaign, $application])}}">
                <x-icon class="fa-solid fa-angle-right" />
            </div>
        </div>
    @endforeach
</div>
{!! $applications->onEachSide(0)->links() !!}
