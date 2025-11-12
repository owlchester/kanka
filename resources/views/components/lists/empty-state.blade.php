<?php
    /** @var \App\Models\EntityType $entityType */
?>
<div class="flex flex-col gap-4 items-center justify-center mx-auto">
    <h2>{!! __('lists.empty.title', ['singular' => strtolower($entityType->name()), 'plural' => strtolower($entityType->plural())]) !!}</h2>
    <x-helper>
        <p>{{ __($entityType->pluralCode() . '.lists.empty') }}</p>
    </x-helper>

    @can('create', [$entityType, $campaign])
        <a href="{{ $entityType->createRoute($campaign) }}" class="btn2 btn-primary mb-6">
            <x-icon class="plus"></x-icon>
            {!! $entityType->name() !!}
        </a>
    @endif

    <div class="flex gap-4 items-center justify-center flex-col lg:flex-row">
        <a href="{{ \App\Facades\Domain::toFront('campaigns') }}">
            <x-icon class="fa-regular fa-sparkles" />
            {{ __('lists.actions.public') }}
        </a>
        <a href="https://docs.kanka.io/en/latest/entities/{{ \Illuminate\Support\Str::replace('_', '-', $entityType->pluralCode()) }}.html">
            <x-icon class="fa-regular fa-book" />
            {{ __('lists.actions.learn') }}
        </a>
    </div>
</div>
