{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'flex-0 form-inline datagrid-search inline-block', 'role' => 'form']) !!}
<div class="field field-search">
    {{ Form::text('term', isset($term) ? $term : null, ['class' => '', 'placeholder' => __('crud.search')]) }}
</div>
{!! Form::close() !!}
