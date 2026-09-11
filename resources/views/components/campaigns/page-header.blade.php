@props([
    'title',
    'learnMoreUrl' => null,
    'lead' => null,
])

<div class="flex gap-2 items-center justify-between">
    <h1 class="text-2xl">{!! $title !!}</h1>

    @if ($learnMoreUrl || isset($actions))
        <div class="flex gap-2 flex-wrap items-center justify-end">
            @if ($learnMoreUrl)
                <x-learn-more :url="$learnMoreUrl" />
            @endif

            @isset($actions)
                {!! $actions !!}
            @endisset
        </div>
    @endif
</div>

@if ($lead !== null)
    <p class="max-w-4xl text-lg">{!! $lead !!}</p>
@endif
