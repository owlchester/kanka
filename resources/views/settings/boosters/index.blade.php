<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings/boosters.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    <x-grid type="1/1">
        @include('partials.errors')

        <h1 class="text-2xl">
            <x-icon class="premium" />
            {{ __('settings/boosters.title') }}
        </h1>

        @if (auth()->user()->hasBoosterNomenclature())
            <x-alert type="warning">
                <x-grid type="1/1">
                    <h3 class="m-0 text-xl">Legacy boosters</h3>
                    <p>
                        Dear user, you are still using our legacy campaign boosters concept. Switching to premium campaigns will unboost your campaigns and give you a number of premium campaigns based on your subscription.
                    </p>
                    <p>
                        As a reminder, premium campaigns are just a renamed superboosted campaign, plus a bunch of new features like <strong>family trees</strong> and <strong>custom modules</strong>. Owlbears get 1, Wyverns 3, and Elementals 7.
                    </p>
                    <p>
                        This action is permanent and cannot be reverted.
                    </p>

                    <button class="btn2 btn-block btn-secondary"
                            data-toggle="dialog"
                            data-target="switch-dialog">
                        Switch to premium
                    </button>
                </x-grid>
            </x-alert>
        @endif

        <x-box>
            <x-grid type="1/1">
                <h3 class="text-xl">{{ __('settings/boosters.pitch.title') }}</h3>
                <p class="">{{ __('settings/boosters.pitch.description') }}</p>

                <h4 class="text-lg">{{ __('settings/boosters.pitch.benefits.title') }}</h4>
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-1">
                    <div class="flex items-center">
                        <div class="p-1 w-12 flex-none">
                            <x-icon class="fa-solid fa-palette fa-2x" />
                        </div>
                        <div class="p-1">
                            {{ __('settings/boosters.pitch.benefits.customisable') }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-1 w-12 flex-none">
                            <i class="fa-solid fa-image-portrait fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="p-1">
                            {{ __('settings/boosters.pitch.benefits.entities') }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-1 w-12 flex-none">
                            <i class="fa-solid fa-hourglass-half fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="p-1">
                            {{ __('settings/boosters.pitch.benefits.backup', ['amount' => config('entities.hard_delete')]) }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-1 w-12 flex-none">
                            <i class="fa-solid fa-horse-head fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="p-1">
                            {{ __('settings/boosters.pitch.benefits.icons') }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-1 w-12 flex-none">
                            <i class="fa-solid fa-camera fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="p-1">
                            {{ __('settings/boosters.pitch.benefits.upload') }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="p-1 w-12 flex-none">
                            <i class="fa-solid fa-user-group fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="p-1">
                            {{ __('settings/boosters.pitch.benefits.relations') }}
                        </div>
                    </div>
                </div>
                <p>{!! __('settings/boosters.pitch.more', ['boosters' => '<a href="https://kanka.io/premiumutm_source=boosters&utm_medium=referral&utm_campaign=findoutmore" class="text-link">' . __('concept.premium-campaigns') . '</a>']) !!}</p>
            </x-grid>
        </x-box>


        <h2 class="">
            {{ __('settings/boosters.ready.title') }}

            @can('boost', auth()->user())
                <div class="badge bg-boost flex gap-1 badge-lg ml-2" data-toggle="tooltip" data-title="{{ __('settings/boosters.ready.available') }}">
                    <x-icon class="premium" />
                    {{ auth()->user()->availableBoosts() }}
                </div>
            @endif
        </h2>
        @if (!auth()->user()->isGoblin())
        <p>{!! __('settings/boosters.ready.pricing', [
        'amount' => '<strong>' . __('settings/boosters.ready.pricing-amount', [
            'currency' => auth()->user()->currencySymbol(),
            'amount' => '5.00'
        ]) . '</strong>'
        ]) !!}</p>
        @endif

        @if ($focus)
            @include('settings.boosters.create', [
                'campaign' => $focus,
                'superboost' => $superboost,
                'cost' => $superboost ? 3 : 1,
                'canSuperboost' => auth()->user()->availableBoosts() >= 3
            ])
        @endif

        <div class="grid grid-cols-1 gap-2 campaign-list">
            @foreach ($boosts as $boost)
                @include('settings.boosters._campaign', ['campaign' => $boost->campaign])
            @endforeach
            @foreach ($campaigns as $c)
                @include('settings.boosters._campaign', ['campaign' => $c])
            @endforeach
        </div>
    </x-grid>
@endsection

@section('modals')
    @parent

    <x-dialog id="switch-dialog" title="Switch to premium">
        <div class="">
            <p>
               Are you sure you want to switch to premium campaigns? This will unboost your campaigns and give you a number of premium campaigns based on your subscription.
            </p>
            <p>This action cannot be reverted.</p>
        </div>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>
            <form method="POST" action="{{ route('settings.switch-to-premium') }}" class="w-full">
            <x-buttons.confirm type="primary" full="true">
                Yes, switch to premium
            </x-buttons.confirm>
                @csrf
            </form>
        </div>
    </x-dialog>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/settings.js')
@endsection
