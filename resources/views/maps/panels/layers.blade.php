@if (auth()->check() && !auth()->user()->settings()->get('tutorial_map_layers'))
    <div class="alert alert-info tutorial">
    <span>
        <button type="button" class="close banner-notification-dismiss" data-dismiss="alert" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'map_layers', 'type' => 'tutorial']) }}">×</button>

        <p>{{ __('maps/layers.helper.amount_v2') }}</p>

        <p>{!!  __('crud.helpers.learn_more', ['documentation' => link_to('https://docs.kanka.io/en/latest/entities/maps/layers.html', '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front.menu.documentation'), ['target' => '_blank'], null, false)])!!}</p>
    </span>
    </div>
@endif

<div class="box box-solid" id="map-layers">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['maps.layers.bulk', 'map' => $model]]) !!} @endif
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('maps.panels.layers') }}
        </h3>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
