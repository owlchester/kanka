<?php /** @var \App\Models\Feature $feature */ ?>
<div class="rounded-2xl bg-white p-5 flex flex-col gap-5 hover:bg-light cursor-pointer" wire:click="open({{ $feature }})">
    <h5 class="break-all">{!! $feature->name !!}</h5>

    <div class="self-end flex align-center items-center justify-center gap-2">
        @include('roadmap.feature._upvote')
    </div>
</div>
