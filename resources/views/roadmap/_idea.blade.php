<?php /** @var \App\Models\Feature $feature */ ?>
<div class="rounded-2xl overflow-hidden flex">
    <div class="flex-none w-40 py-5 bg-purple text-white">
        @include('roadmap.feature._upvote')
    </div>
    <div class="bg-gray-200 p-5 flex-grow flex flex-col gap-5">
        <h2 class="text-md">{{ $feature->name }}</h2>
        <p>{!! nl2br($feature->description) !!}</p>
    </div>
</div>
