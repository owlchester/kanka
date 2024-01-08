<?php /** @var \App\Models\Feature $feature */ ?>
<div class="rounded-2xl overflow-hidden flex">
    <div class="flex-none w-40 py-5 bg-purple text-white">
        <div class="flex gap-2 align-center items-center justify-center text-md">
            <i class="fa-regular fa-heart" aria-hidden="true"></i>
            {{ number_format($feature->upvote_count) }}
        </div>
    </div>
    <div class="bg-gray-200 p-5 flex-grow flex flex-col gap-5">
        <h2 class="text-md">{{ $feature->name }}</h2>
        <p>{!! nl2br($feature->description) !!}</p>
    </div>
</div>
