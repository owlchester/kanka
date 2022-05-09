{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'form-inline datagrid-search', 'role' => 'form']) !!}
<div class="form-group has-feedback">
    {{ Form::text('search', isset($filterService) ? $filterService->search() : null, ['class' => 'form-control', 'placeholder' => __('crud.search')]) }}
    <i class="fa fa-solid fa-search form-control-feedback"></i>
</div>
{!! Form::close() !!}
