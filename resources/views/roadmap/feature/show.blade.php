<?php /** @var \App\Models\Feature $feature */ ?>
<header class="bg-purple text-white rounded-t-2xl">
    <h4 class="text-md">
        {!! $feature->name !!}
    </h4>
    <button autofocus type="button" class="text-md self-start" onclick="this.closest('dialog').close('close')" title="{{ __('crud.delete_modal.close') }}">
        <x-icon class="fa-regular fa-times"></x-icon>
        <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
    </button>
</header>
<article class="max-w-2xl">
    <div class="flex gap-5 w-full">
        <p class="m-0 flex-grow text-blue">{{ $feature->category->name }}</p>

        <div class="self-end flex align-center items-center justify-center gap-2 @if (auth()->check()) cursor-pointer @endif" @if (auth()->check()) data-upvote="{{ route('roadmap.upvote', [$feature]) }}" @endif data-error="Subscribe to upvote ideas">
            @include('roadmap.feature._upvote')
        </div>
    </div>
    <p>{!! nl2br($feature->description) !!}</p>
</article>
<footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3 md:rounded-b">

</footer>
