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

            <a href="//docs.kanka.io/en/latest/features/campaigns/modules.html"
               target="_blank" class="btn2 btn-sm btn-ghost">
                <x-icon class="question" />
                {!! __('crud.actions.help') !!}
            </a>
            @can('update', $campaign)
            @if ($canReset)
                <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="reset-confirm">
                    <i class="fa-solid fa-eraser" aria-hidden="true"></i>
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">
            @foreach ($entityTypes as $entityType)
                <div class="cell col-span-1 flex">
                    @includeWhen($entityType->isSpecial(), 'campaigns.entity-types.box.custom')
                    @includeWhen(!$entityType->isSpecial(), 'campaigns.entity-types.box.default')
                </div>
            @endforeach

                <div class="cell col-span-1 flex">
                    @include('campaigns.entity-types.box.new')
                </div>
        </div>

        <h3 id="features">{{ __('campaigns/modules.sections.features')}}</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">

            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => 'fa-solid fa-suitcase', 'module' => 'inventories'])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => 'fa-solid fa-table', 'module' => 'entity_attributes'])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => 'fa-solid fa-folder', 'module' => 'assets'])
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="rename-dialog" :loading="true"></x-dialog>

    <x-dialog id="reset-confirm" :title="__('campaigns/modules.reset.title')">
        <p>{{ __('campaigns/modules.reset.warning') }}</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            <x-form method="DELETE" :action="['modules.reset', $campaign]">
            <x-buttons.confirm type="danger" full="true" outline="true">
                {{ __('crud.click_modal.confirm') }}
            </x-buttons.confirm>
            </x-form>
        </div>
    </x-dialog>
@endsection
