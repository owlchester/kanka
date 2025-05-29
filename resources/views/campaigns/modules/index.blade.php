@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.modules') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.modules')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
@section('content')
    @include('ads.top')
    @include('partials.errors')
    <div class="grow flex flex-col gap-5" id="campaign-modules">

        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.modules') }}
            </h3>
            <x-learn-more url="features/campaigns/modules.html" />
            @can('update', $campaign)
            @if ($canReset)
                <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="reset-confirm">
                    <i class="fa-regular fa-eraser" aria-hidden="true"></i>
                    {{ __('crud.actions.reset') }}
                </a>
            @endif
            @endcan
        </div>

        <x-tutorial code="campaign_modules">
            <p>
                {{ __('campaigns/modules.helpers.info') }}
            </p>
        </x-tutorial>

        @includeWhen(config('entities.custom'), 'campaigns.modules._custom')
        @include('campaigns.modules._default')
        @include('campaigns.modules._features')
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="rename-dialog" :loading="true"></x-dialog>

    <x-dialog id="reset-confirm" :title="__('campaigns/modules.reset.title')">
        <x-helper>{{ __('campaigns/modules.reset.warning') }}</x-helper>
        <x-helper>{{ __('campaigns/modules.reset.default') }}</x-helper>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            <x-form method="DELETE" :action="['modules.reset', $campaign]">
            <x-buttons.confirm type="danger" full="true" outline="true">
                {{ __('crud.actions.confirm') }}
            </x-buttons.confirm>
            </x-form>
        </div>
    </x-dialog>
@endsection
