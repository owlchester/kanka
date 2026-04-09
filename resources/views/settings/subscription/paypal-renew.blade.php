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
                <div class="flex gap-2 flex-col ">
                    <div class="flex justify-between gap-2">
                        <img class="w-16 h-16 " src="{{ $tier->image() }}" alt="{{ $tier->name }}"/>
                    </div>
                    <div class="grow flex flex-col gap-2 w-full">
                        <div class="text-lg">
                            {{ $tier->name }}
                        </div>
                        @if ($tier->isFree())
                            <div class="price text-neutral-content">
                                {{ __('front.features.patreon.free') }}
                            </div>
                        @else
                            <div class="price price-yearly flex gap-2 w-full items-end">
                                <div class="text-2xl">
                                    {{ $user->currencySymbol() }}
                                    {{ number_format($tier->price($user->currency(), \App\Enums\PricingPeriod::Yearly), 2) }}
                                </div>
                                <span class="text-sm text-neutral-content ">{{ __('tiers.periods.billed_yearly') }}</span>
                            </div>
                        @endif

                        @if ($tier->code === 'owlbear')
                            <p class="">{{ __('tiers.target.owlbear') }}</p>
                        @elseif ($tier->isWyvern())
                            <p class="">{{ __('tiers.target.wyvern') }}</p>
                        @elseif ($tier->code === 'elemental')
                            <p class="">{{ __('tiers.target.elemental') }}</p>
                        @endif
                    </div>
                </div>

                @php
                    $isDowngrade = match($user->pledge) {
                        'Elemental' => in_array($tier->name, ['Owlbear', 'Wyvern']),
                        'Wyvern'    => $tier->name === 'Owlbear',
                        default     => false,
                    };
                @endphp

                @if (!$isDowngrade)
                    <x-form :action="['paypal.renew-process', 'tier' => $tier]" class="w-full" direct>
                        <button type="submit" class="btn2 btn-primary btn-block">
                                {{ $tier->isCurrent($user)
                                    ? __('subscriptions/renew.actions.renew')
                                    : __('tiers.actions.subscribe.upgrade', ['tier' => $tier->name]) }}
                        </button>
                    </x-form>
                @endif

                <div class="flex flex-col gap-2">
                    @include('settings.subscription.tiers.benefits._' . strtolower($tier->name))
                </div>


            </article>
        @endforeach
    </div>
</x-grid>
@endsection
