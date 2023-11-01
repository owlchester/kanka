{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'flex-0 form-inline datagrid-search inline-block', 'role' => 'form']) !!}
<div class="field field-search">
    {{ Form::text('search', isset($filterService) ? $filterService->search() : null, ['class' => '', 'placeholder' => __('crud.search')]) }}
</div>
<input type="hidden" name="m" value="{{ $mode }}" />
{!! Form::close() !!}
