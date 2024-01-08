<?php /** @var \App\Models\Feature $feature */ ?>
<div class="rounded-2xl overflow-hidden flex">
    <div class="flex-none w-40 py-5 bg-purple text-white">
        <div class="flex gap-2 align-center items-center justify-center text-md @if (auth()->check()) cursor-pointer @endif" title="Upvote this idea" @if (auth()->check()) data-upvote="{{ route('roadmap.upvote', [$feature]) }}" @endif data-error="Subscribe to upvote ideas" >
        @include('roadmap.feature._upvote')
        </div>
    </div>
    <div class="bg-gray-200 p-5 flex-grow flex flex-col gap-5">
        <h2 class="text-md">{{ $feature->name }}</h2>
        <p>{!! nl2br($feature->description) !!}</p>
    </div>
</div>
