<?php /** @var \App\Models\Feature $feature */ ?>
<div class="rounded-2xl overflow-hidden flex" wire:key="idea-block-{{ $feature->id }}">
    <div class="flex-none w-40 py-5 bg-purple text-white">

        <div class="flex gap-2 align-center items-center justify-center text-md">
            @livewire('roadmap.upvote', ['feature' => $feature], key("idea-{$feature->id}"))
        </div>
    </div>
    <div class="bg-gray-200 p-5 flex-grow flex flex-col gap-5">
        <h2 class="text-md">{{ $feature->name }}</h2>
        {!! $feature->cleanDescription() !!}
    </div>
</div>

