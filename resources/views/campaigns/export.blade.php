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
            <h1 class="text-2xl">
                {{ __('campaigns/export.title') }}
            </h1>
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
    <x-dialog id="export-confirm" :title="__('campaigns/export.confirm.title', ['name' => $campaign->name])">
        @can('export', $campaign)
            <x-helper>
                <p>{!! __('campaigns/export.confirm.warning', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}</p>
            </x-helper>
            <x-form :action="['campaign.export-process', $campaign]">
                <x-grid type="1/1">
                    <x-forms.field
                        field="type"
                        required
                        :label="__('campaigns/export.confirm.type')">
                        <div class="grid grid-cols-2 gap-4">


                            <div class="rounded-xl border p-2 flex gap-2 items-start hover:shadow-sm @if(!$campaign->premium()) cursor-not-allowed bg-base-200 @else cursor-pointer @endif">
                                <input type="radio" name="type" id="md" value="2"
                                       @if(!$campaign->premium()) disabled="disabled" @else checked="checked" @endif class="mt-2">

                                <label for="md" class="w-full @if(!$campaign->premium()) cursor-not-allowed @else cursor-pointer @endif flex flex-col gap-0.5">
                                    <span class="text-semibold text-lg">
                                        <x-icon class="fa-brands fa-markdown" />
                                        {{ __('campaigns/export.types.md') }}
                                    </span>
                                    <p class="text-xs text-neutral-content">
                                        {{ __('campaigns/export.helpers.markdown') }}
                                    </p>
                                    @if(!$campaign->premium())
                                        <a href="{{ route('settings.subscription', ['f' => 'export', 'w' => $campaign->id]) }}" class="text-xs">
                                            {{ __('campaigns/export.helpers.premium') }}</a>
                                    @endif
                                </label>
                            </div>

                            <div class="rounded-xl border p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                                <input type="radio" name="type" id="json" value="1" @if (!$campaign->premium()) checked="checked" @endif class="mt-2">

                                <label for="json" class="w-full cursor-pointer flex flex-col gap-0.5">
                                    <span class="text-semibold text-lg">
                                        <x-icon class="fa-regular fa-code" />
                                        {{ __('campaigns/export.types.json') }}
                                    </span>
                                    <p class="text-xs text-neutral-content">
                                        {{ __('campaigns/export.helpers.json') }}
                                    </p>
                                </label>
                            </div>
                        </div>
                    </x-forms.field>

                        <p class="text-xs text-neutral-content">
                            {!! __('campaigns/export.confirm.notification', ['admin' => '<a href="' . route(
            'campaigns.campaign_roles.admin',
            $campaign,
        ) . '">' . $campaign->adminRoleName() . '</a>']) !!}
                        </p>

                    <div class="grid grid-cols-2 gap-2 w-full">
                        <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                            {{ __('crud.cancel') }}
                        </x-buttons.confirm>

                        <x-buttons.confirm type="primary" full="true">
                            {{ __('crud.actions.confirm') }}
                        </x-buttons.confirm>
                    </div>
                </x-grid>
            </x-form>
        @else
            <x-helper>
                <p>
                    {{ __('campaigns/export.errors.limit') }}
                </p>
            </x-helper>
        @endif
    </x-dialog>
@endsection
