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
        <x-campaigns.page-header
            :title="__('campaigns.show.tabs.achievements')"
            learn-more-url="features/campaigns/achievements.html"
        />
        @if (!$campaign->superboosted())
            <x-premium-cta-alert :campaign="$campaign" source="achievements">
                <x-slot name="title">
                    {!! __('campaigns/achievements.cta.title') !!}
                </x-slot>
                <x-slot name="lead">
                    {!! __('campaigns/achievements.cta.lead') !!}
                </x-slot>
            </x-premium-cta-alert>
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
