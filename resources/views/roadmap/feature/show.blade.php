<?php /** @var \App\Models\Feature $feature */ ?>

<header class="bg-purple text-white rounded-t-2xl flex flex-col gap-2 p-4">
    <div class="flex gap-2 w-full justify-between">
        <h4 class="text-md text-left!">
            {!! $feature->name !!}
        </h4>
        <button autofocus type="button" class="text-md" onclick="this.closest('dialog').close('close')" title="{{ __('crud.actions.close') }}">
            <x-icon class="fa-regular fa-times" />
            <span class="sr-only">{{ __('crud.actions.close') }}</span>
        </button>
    </div>
    <div class="flex gap-5 w-full">
        <p class="m-0 grow text-light">
            @if ($feature->category){!! $feature->category->name !!}@endif
        </p>

        <div class="self-end flex align-center items-center justify-center gap-2">
            @livewire('roadmap.upvote', ['feature' => $feature, 'col' => false])
        </div>
    </div>
</header>
<article class="max-w-2xl p-4 ">
    {!! $feature->cleanDescription() !!}
</article>
<footer class="flex flex-wrap gap-3 justify-between items-start p-3 md:rounded-b">

</footer>
