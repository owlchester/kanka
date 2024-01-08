<?php /** @var \App\Models\Feature $feature **/ ?>
<div class="flex flex-col gap-5">


@foreach ($ideas as $feature)
    @include('roadmap.feature._idea', $feature)
@endforeach

@if($hasMorePages)
    <div class="text-center">
        <button
            class="btn-round rounded-full"
            wire:click="loadIdeas"
        >
            Load more
        </button>
    </div>
@endif
</div>
