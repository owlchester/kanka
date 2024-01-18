<?php /** @var \App\Models\Feature $feature */?>
@if (auth()->check() && $feature->uservote)
    <i class="fa-solid fa-heart" aria-hidden="true"></i>
@else
    <i class="fa-regular fa-heart" aria-hidden="true"></i>
@endif
{{ number_format($feature->upvote_count) }}
