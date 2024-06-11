<div class="" id="timeline-eras">
    @if(Datagrid::hasBulks())
        <x-form :action="['timelines.eras.bulk', $campaign, 'timeline' => $model]" direct>
            <div id="datagrid-parent" class="">
                @include('layouts.datagrid._table')
            </div>
        </x-form>
    @else
        <div id="datagrid-parent" class="">
            @include('layouts.datagrid._table')
        </div>
    @endif

</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
