<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<div class="flex gap-2 items-center mb-5">
    <h3 class="m-0 inline-block grow">
        {{ __('campaigns.show.tabs.plugins') }}
    </h3>
    <a href="{{ config('marketplace.url') }}" target="_blank" class="btn2 btn-primary">
        {{ __('campaigns/plugins.actions.go_to_marketplace') }} <i class="fa-solid fa-external-link-alt"></i>
    </a>
</div>

@if($campaign->boosted())
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['campaign_plugins.bulk', $campaign]]) !!} @endif
    <div id="datagrid-parent">
        @include('layouts.datagrid._table', ['empty' => __('campaigns/plugins.empty_list'), 'responsive' => true])
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
@else
    <x-cta :campaign="$campaign">
        <p>{!! __('campaigns/plugins.pitch', ['marketplace' => link_to(config('marketplace.url'), __('footer.marketplace'), null, ['target' => '_blank'])]) !!}</p>
    </x-cta>
@endif


@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])

    <x-dialog id="plugin-update" :loading="true"></x-dialog>
@endsection
