<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<x-campaigns.page-header :title="__('campaigns.show.tabs.plugins')">
    <x-slot name="actions">
        <a href="{{ config('marketplace.url') }}" class="btn2 btn-primary btn-sm">
            {{ __('campaigns/plugins.actions.find-plugins') }} <x-icon class="link" />
        </a>
    </x-slot>
</x-campaigns.page-header>

@if(!$campaign->boosted())
    <x-premium-cta-alert :campaign="$campaign" source="plugins">
        <x-slot name="title">
            {!! __('campaigns/plugins.cta.title') !!}
        </x-slot>
        <x-slot name="lead">
            {!! __('campaigns/plugins.cta.lead') !!}
        </x-slot>
    </x-premium-cta-alert>
@endif

@if ($rows->total() === 0)
    <x-box class="border-dashed border-neutral-content border">
        <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2 text-center">
            <div class="font-bold text-lg">{{ __('campaigns/plugins.empty.title') }}</div>
            <p class="text-neutral-content mb-4">{{ __('campaigns/plugins.empty.description') }}</p>
            <a href="{{ config('marketplace.url') }}" class="btn2 btn-primary">
                {{ __('campaigns/plugins.actions.find-plugins') }}
                <x-icon class="link" />
            </a>
        </div>
    </x-box>
@elseif(Datagrid::hasBulks())
    <x-form :action="['campaign_plugins.bulk', $campaign]" direct>
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    </x-form>
@else
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
@endif


@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    <x-dialog id="plugin-update" :loading="true"></x-dialog>
@endsection
