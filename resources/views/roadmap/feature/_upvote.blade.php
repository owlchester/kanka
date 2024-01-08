<?php /** @var \App\Models\Feature $feature */?>

<div class="flex gap-2 align-center items-center justify-center text-md @if (auth()->check()) cursor-pointer @endif" title="Upvote this idea" @if (auth()->check()) data-upvote="{{ route('roadmap.upvote', [$feature]) }}" @endif>

    @if (auth()->check() && $feature->uservote)
        <i class="fa-solid fa-heart" aria-hidden="true"></i>
    @else
        <i class="fa-regular fa-heart" aria-hidden="true"></i>
    @endif
    {{ number_format($feature->upvote_count) }}
</div>
