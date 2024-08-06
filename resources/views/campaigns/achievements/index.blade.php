@php
use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/stats.title', ['campaign' => $campaign->name]),
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
            <h3 class="inline-block grow">
            {{ __('campaigns.show.tabs.achievements') }}
            </h3>

            @if ($campaign->superboosted())
                <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                             data-target="stats-help">
                    <x-icon class="question" />
                    {{ __('crud.actions.help') }}
                </button>
            @endif
        </div>
        @if (!$campaign->superboosted())
            <x-cta :campaign="$campaign" superboost="true">
                <p>{{ __('campaigns/stats.pitch') }}</p>
            </x-cta>
        @else

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

@section('modals')

    @include('partials.helper-modal', [
        'id' => 'stats-help',
        'title' => __('campaigns.show.tabs.achievements'),
        'textes' => [
            __('campaigns/stats.helper')
    ]])
@endsection

