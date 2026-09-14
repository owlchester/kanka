<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings.menu.premium'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        @include('partials.errors')

        <div class="flex gap-1 justify-between">
            <h1 class="text-2xl">
                {{ __('settings.menu.premium') }}
            </h1>

            @if (config('app.debug'))
                <a href="{{ route('settings.switch-back') }}" class="btn2 btn-xs btn-outline btn-error">
                    Switch to legacy
                </a>
            @endif
        </div>

        @include('settings.premium.benefits')


        <div class="flex gap-2 items-center justify-between">
            <h2 class="">
                {{ __('settings/premium.ready.title') }}
            </h2>
            @can('boost', auth()->user())
                <div class="flex gap-2 items-center rounded-2xl px-2 py-1 bg-primary text-primary-content font-bold" data-toggle="tooltip" data-title="{{ __('settings/premium.ready.available') }}">
                    <x-icon class="premium" />
                    {{ auth()->user()->availableBoosts() }} / {{ auth()->user()->maxBoosts() }}
                </div>
            @endcan
        </div>

        <div class="grid grid-cols-1 gap-2 campaign-list">
            @foreach ($premiums as $premium)
                @include('settings.boosters._campaign', ['campaign' => $premium->campaign])
            @endforeach
            @foreach ($campaigns as $userCampaign)
                @include('settings.boosters._campaign', ['campaign' => $userCampaign])
            @endforeach
        </div>
    </x-grid>

@endsection

@section('modals')
    @parent
    @if ($focus)
        <input type="hidden" id="focus-modal" data-url="{{ route('campaign_boosts.create', ['campaign' => $focus, 'boost' => 1]) }}" data-target="primary-dialog" />
    @endif
@endsection

@section('scripts')
    @parent
    @vite('resources/js/settings.js')
@endsection
