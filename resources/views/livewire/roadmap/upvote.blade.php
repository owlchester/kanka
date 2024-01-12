<div class="flex gap-2 align-center items-center justify-center @if ($col) flex-col @endif text-center">
    <div wire:click="upvote" class="hover:text-red-300 cursor-pointer">
        @if (auth()->check())
            @if ($feature->uservote)
                <i class="fa-solid fa-heart text-red-300" aria-hidden="true"></i>
            @else
                <i class="fa-regular fa-heart" aria-hidden="true"></i>
            @endif
        @else
            <i class="fa-regular fa-heart" aria-hidden="true"></i>
        @endif
        {{ number_format($count) }}
    </div>

    @if ($isGuest)
        <a href="{{ route('login') }}" class="link-light">Log in to upvote</a>
    @elseif ($isUnsubbed)
        <a href="{{ route('settings.subscription') }}" class="link-light">Subscribe to upvote</a>
    @endif
</div>
