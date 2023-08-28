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
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-5 flex-col max-w-7xl achievements">
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
            {{ __('campaigns.show.tabs.achievements') }}
            </h3>

            @if ($campaign->superboosted())
                <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                             data-target="stats-help">
                    <x-icon class="question"></x-icon>
                    {{ __('crud.actions.help') }}
                </button>
            @endif
        </div>
        @if (!$campaign->superboosted())
            <x-cta :campaign="$campaign" superboost="true">
                <p>{{ __('campaigns/stats.pitch') }}</p>
            </x-cta>
        @else

        @foreach ($stats as $key => $stat)
            <div class="shadow-xs h-24 w-full overflow-hidden rounded flex align-center items-stretch drop-shadow level-{{ $stat['level'] }} @if($stat['level'] == 0) bg-base-200 text-base-content @elseif ($stat['level'] == 5) bg-warning text-warning-content @else bg-primary text-primary-content @endif">
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
@endsection

@section('modals')

    @include('partials.helper-modal', [
        'id' => 'stats-help',
        'title' => __('campaigns.show.tabs.achievements'),
        'textes' => [
            __('campaigns/stats.helper')
    ]])
@endsection

