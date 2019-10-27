{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'form-inline datagrid-search', 'role' => 'form']) !!}
<div class="form-group has-feedback">
    {{ Form::text('search', $filterService->search(), ['class' => 'form-control', 'placeholder' => trans('crud.search')]) }}
    <i class="fa fa-search form-control-feedback"></i>
</div>
{!! Form::close() !!}