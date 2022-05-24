@php
use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/stats.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.achievements')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'stats'])
        </div>
        <div class="col-md-9 achievements">
            <h3 class="mt-0">
                {{ __('campaigns.show.tabs.achievements') }}
                <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                        data-target="stats-help">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    {{ __('campaigns.members.actions.help') }}
                </button>
            </h3>
            @if (!$campaign->superboosted())
                @include('partials.superboosted', ['callout' => true])

                <div class="row">
                    <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                        @include('partials.images.boosted-image')
                    </div>
                </div>
            @else

            @foreach ($stats as $key => $stat)
                <div class="info-box level-{{ $stat['level'] }} @if($stat['level'] == 0) bg-gray @elseif ($stat['level'] == 5) bg-yellow @else bg-aqua @endif">
                    <span class="info-box-icon">
                        <i class="{{ $stat['icon'] }}"></i><br />
                    </span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{  __('campaigns/stats.titles.' . $key, ['level' => Arr::get($stat, 'level', 0)])}}</span>
                        <span class="info-box-number">{{ __('campaigns/stats.targets.' . $key, [
                        'target' => Arr::get($stat, 'target', 0),
                    ]) }}</span>
                        @if($stat['level'] < 5)
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ Arr::get($stat, 'progress', 0) }}%"></div>
                        </div>
                        <span class="progress-description">
                        {{ __('campaigns/stats.placeholder', [
'amount' =>  Arr::get($stat, 'amount', 0),
'target' =>  Arr::get($stat, 'target', 0),
]) }}
                        </span>
                        @endif

                    </div>
                </div>
            @endforeach
            @endif
        </div>
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

