@php
use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.achievements') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.achievements')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-5 flex-col achievements">
        <div class="flex gap-2 items-center">
            <h1 class="inline-block grow text-2xl">
            {{ __('campaigns.show.tabs.achievements') }}
            </h1>

            <x-learn-more url="features/campaigns/achievements.html" />
        </div>
        @if (!$campaign->superboosted())
            <x-premium-cta :campaign="$campaign" superboost>
                <p>{{ __('campaigns/achievements.pitch') }}</p>
            </x-premium-cta>
        @else

            <p>{!! __('campaigns/achievements.tutorial') !!}</p>

        <div class="flex flex-wrap gap-5">
        @foreach ($achievements as $key => $stat)
                @if ($stat['level'] === 5)
                    @include('campaigns.achievements._finished')
                @else
                    @include('campaigns.achievements._locked')
                @endif
            @endforeach
        </div>
        @endif
    </div>
@endsection

