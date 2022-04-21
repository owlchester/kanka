<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\Plugin $plugin
 */?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h4 class="box-title">
            <i class="fa fa-gift"></i> {{ __('campaigns.show.tabs.plugins') }}
        </h4>
    </div>
    <div class="box-body">

        <p class="help-block">{{ __('campaigns/plugins.helper')}}</p>

        <p class="text-center">
            <a href="{{ config('marketplace.url') }}" target="_blank" class="btn btn-large btn-primary">
                {{ __('campaigns/plugins.actions.go_to_marketplace') }} <i class="fa fa-external-link-alt"></i>
            </a>
        </p>
    </div>
</div>


@if($campaign->boosted())
<div class="box box-solid">

    @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'campaign_plugins.bulk']) !!} @endif
    <div id="datagrid-parent" class="table-responsive">
        @include('campaigns.plugins._table', ['empty' => __('campaigns/plugins.empty_list')])
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
</div>
@endif


@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])
@endsection
