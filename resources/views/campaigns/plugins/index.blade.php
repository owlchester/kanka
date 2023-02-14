<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<div class="mb-3">
    <a href="{{ config('marketplace.url') }}" target="_blank" class="btn pull-right btn-primary">
        {{ __('campaigns/plugins.actions.go_to_marketplace') }} <i class="fa-solid fa-external-link-alt"></i>
    </a>
    <h3 class="mt-0 inline-block">
        {{ __('campaigns.show.tabs.plugins') }}
    </h3>
</div>

@if($campaign->boosted())
    <div class="box box-solid">
        @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['campaign_plugins.bulk', $campaign]]) !!} @endif
        <div id="datagrid-parent" class="table-responsive">
            @include('campaigns.plugins._table', ['empty' => __('campaigns/plugins.empty_list')])
        </div>
        @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
    </div>
@else
    @include('layouts.callouts.boost', ['texts' => [__('campaigns/plugins.pitch', ['marketplace' => link_to(config('marketplace.url'), __('front.menu.marketplace'), null, ['target' => '_blank'])])]])
@endif


@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])
@endsection
