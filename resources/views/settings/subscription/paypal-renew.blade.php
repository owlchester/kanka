<?php
/**
 * @var \App\Models\User $user
 * @var \Illuminate\Database\Eloquent\Collection|\App\Models\Tier[] $tiers
 */
?>
@extends('layouts.app', [
    'title' => __('subscriptions/renew.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
<x-grid type="1/1">
    <h1 class="text-2xl">{{ __('subscriptions/renew.title') }}</h1>

    <x-helper>
        <p>
            {!! __('subscriptions/paypal-renew.intro', [
                'date' => '<strong>' . $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') . '</strong>',
            ]) !!}
        </p>
    </x-helper>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($tiers as $tier)
            <article class="rounded-2xl bg-box flex flex-col gap-4 p-4 relative shadow-xs hover:shadow-md @if ($tier->isCurrent($user)) border-primary border @endif">
                <div class="flex gap-2 items-center">
                    <img src="{{ $tier->image() }}" alt="{{ $tier->name }}" class="w-10 h-10" />
                    <h2 class="text-xl m-0">{{ $tier->name }}</h2>
                    @if ($tier->isCurrent($user))
                        <span class="badge badge-primary badge-sm">{{ __('tiers.current') }}</span>
                    @endif
                </div>

                @include('settings.subscription.tiers.benefits._' . strtolower($tier->name))

                @php
                    $isDowngrade = match($user->pledge) {
                        'Elemental' => in_array($tier->name, ['Owlbear', 'Wyvern']),
                        'Wyvern'    => $tier->name === 'Owlbear',
                        default     => false,
                    };
                @endphp

                @if (!$isDowngrade)
                    <x-form :action="['paypal.renew-process', 'tier' => $tier]" class="mt-auto">
                        <x-buttons.confirm type="primary" class="btn-block">
                            {{ $tier->isCurrent($user)
                                ? __('subscriptions/renew.actions.renew')
                                : __('tiers.actions.subscribe.upgrade', ['tier' => $tier->name]) }}
                        </x-buttons.confirm>
                    </x-form>
                @endif
            </article>
        @endforeach
    </div>
</x-grid>
@endsection
