@extends('layouts.app', [
    'title' => __('campaigns/export.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.export')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('ads.top')
        @include('partials.errors')

        <div class="flex gap-2 items-center justify-between">
            <h3 class="">
                {{ __('campaigns/export.title') }}
            </h3>
            <div class="flex gap-2 flex-wrap items-center">
                <x-learn-more url="features/campaigns/export.html" />
                <a href="#" class="btn2 btn-sm btn-primary" data-toggle="dialog" data-target="export-confirm">
                    <x-icon class="fa-regular fa-download" />
                    {{ __('campaigns/export.actions.export') }}
                </a>
            </div>
        </div>

        <div id="datagrid-parent" class="table-responsive">
            @livewire('campaigns.exports-table', ['campaign' => $campaign])
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="export-confirm" :title="__('campaigns/export.confirm.title')">
        @can('export', $campaign)
            <x-helper>
                <p>{!! __('campaigns/export.confirm.warning', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}</p>
            </x-helper>
            <x-helper>
                <p>{!! __('campaigns/export.confirm.notification', ['admin' => '<a href="' . route(
            'campaigns.campaign_roles.admin',
            $campaign,
        ) . '">' . $campaign->adminRoleName() . '</a>']) !!}</p>
            </x-helper>

            <div class="grid grid-cols-2 gap-2 w-full">
                <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                    {{ __('crud.cancel') }}
                </x-buttons.confirm>

                <x-form :action="['campaign.export-process', $campaign]">
                    <x-buttons.confirm type="primary" full="true">
                        {{ __('crud.actions.confirm') }}
                    </x-buttons.confirm>
                </x-form>
            </div>
        @else
            <x-helper>
                <p>
                    {{ __('campaigns/export.errors.limit') }}
                </p>
            </x-helper>
        @endif
    </x-dialog>
@endsection
