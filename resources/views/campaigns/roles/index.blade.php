<?php /** @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignRole $plugin
 */?>
    <div class="box box-solid">
        @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'campaign_roles.bulk']) !!} @endif
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
        @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
    </div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])
@endsection