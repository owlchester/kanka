@php
use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/stats.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.achievements')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'stats'])
        </div>
        <div class="grow max-w-7xl achievements">
            <div class="flex gap-2 items-center mb-5">
                <h3 class="m-0 inline-block grow">
                {{ __('campaigns.show.tabs.achievements') }}
                </h3>

                @if ($campaign->superboosted())
                    <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                                 data-target="stats-help">
                        <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                        {{ __('campaigns.members.actions.help') }}
                    </button>
                @endif
            </div>
            @if (!$campaign->superboosted())
                @include('layouts.callouts.boost', ['texts' => [
            __('campaigns/stats.pitch')], 'superboost' => true])
            @else

            @foreach ($stats as $key => $stat)
                <div class="info-box drop-shadow h-24 block w-full rounded mb-4 flex align-center items-stretch level-{{ $stat['level'] }} @if($stat['level'] == 0) bg-gray @elseif ($stat['level'] == 5) bg-yellow @else bg-aqua @endif">
                    <div class="flex items-center justify-center flex-0 info-box-icon text-4xl w-20">
                        <i class="{{ $stat['icon'] }}"></i><br />
                    </div>

                    <div class="py-1 flex-grow">
                        <span class="px-2 text-uppercase truncate block">{{  __('campaigns/stats.titles.' . $key, ['level' => Arr::get($stat, 'level', 0)])}}</span>
                        <span class="px-2 block font-bold text-lg">{{ __('campaigns/stats.targets.' . $key, [
                        'target' => Arr::get($stat, 'target', 0),
                    ]) }}</span>
                        @if($stat['level'] < 5)
                        <div class="progress my-1">
                            <div class="progress-bar" style="width: {{ Arr::get($stat, 'progress', 0) }}%"></div>
                        </div>
                        <span class="px-2 m-0 progress-description truncate block">
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

