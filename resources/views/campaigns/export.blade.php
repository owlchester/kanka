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

        <div class="flex gap-2 items-center">
            <h3 class="grow">
                {{ __('campaigns/export.title') }}
            </h3>
            <a href="https://docs.kanka.io/en/latest/features/campaigns/export.html" target="_blank" class="btn2 btn-sm btn-ghost">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </a>
            @if ($campaign->exportable())
                <a href="#" class="btn2 btn-sm btn-primary" data-toggle="dialog" data-target="export-confirm">
                    <x-icon class="fa-solid fa-download" />
                    {{ __('campaigns/export.actions.export') }}
                </a>
            @endif
        </div>

        @if (!$campaign->exportable() && !session()->has('success'))
        <x-alert type="warning">
            {{ __('campaigns/export.errors.limit') }}
        </x-alert>
        @endif

        <div class="box box-solid">
            <div id="datagrid-parent" class="table-responsive">
                @livewire('campaigns.exports-table', ['campaign' => $campaign])
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="export-confirm" :title="__('campaigns/export.confirm.title')">
        <p>{{ __('campaigns/export.confirm.warning') }}</p>

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
    </x-dialog>
@endsection
