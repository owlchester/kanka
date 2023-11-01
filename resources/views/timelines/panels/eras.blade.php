<div class="" id="timeline-eras">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['timelines.eras.bulk', $campaign, 'timeline' => $model]]) !!} @endif
    <div id="datagrid-parent" class="">
        @include('layouts.datagrid._table')
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
