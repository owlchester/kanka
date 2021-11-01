@php
use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/stats.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => trans('campaigns.index.title')],
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
            @if (!$campaign->superboosted())
                <div class="box no-border">
                    <div class="box-body">

                        <p class="help-block">
                            {{ __('campaigns/stats.helper') }}
                        </p>
                        @include('partials.superboosted', ['callout' => true])
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

                <p class="help-block">
                    {{ __('campaigns/stats.helper') }}
                </p>


            @endif
        </div>
    </div>
@endsection

