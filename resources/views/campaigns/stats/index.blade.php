@php
use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/stats.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
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
                    <button class="btn2 btn-sm pull-right" data-toggle="dialog"
                                 data-target="stats-help">
                        <x-icon class="question"></x-icon>
                        {{ __('campaigns.members.actions.help') }}
                    </button>
                @endif
            </div>
            @if (!$campaign->superboosted())
                <x-cta :campaign="$campaign" superboost="true">
                    <p>{{ __('campaigns/stats.pitch') }}</p>
                </x-cta>
            @else

            @foreach ($stats as $key => $stat)
                <div class="shadow-xs h-24 block w-full overflow-hidden rounded mb-4 flex align-center items-stretch level-{{ $stat['level'] }} @if($stat['level'] == 0) bg-base-200 text-base-content @elseif ($stat['level'] == 5) bg-warning text-warning-content @else bg-primary text-primary-content @endif">
                    <div class="flex items-center justify-center flex-none bg-slate-800/20 text-4xl w-20">
                        <i class="{{ $stat['icon'] }}"></i><br />
                    </div>

                    <div class="py-1 flex-grow">
                        <span class="px-2 text-uppercase truncate block">{{  __('campaigns/stats.titles.' . $key, ['level' => Arr::get($stat, 'level', 0)])}}</span>
                        <span class="px-2 block font-bold text-lg">{{ __('campaigns/stats.targets.' . $key, [
                        'target' => Arr::get($stat, 'target', 0),
                    ]) }}</span>
                        @if($stat['level'] < 5)
                        <div class="h-0.5 w-full bg-gray-400 my-1">
                            <div class="h-full bg-white" style="width: {{ Arr::get($stat, 'progress', 0) }}%"></div>
                        </div>
                        <span class="px-2 m-0 truncate block">
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

