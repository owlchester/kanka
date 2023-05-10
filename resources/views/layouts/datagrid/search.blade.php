{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'flex-0 form-inline datagrid-search inline-block', 'role' => 'form']) !!}
<div class="form-group has-feedback mb-0">
    {{ Form::text('search', isset($filterService) ? $filterService->search() : null, ['class' => 'form-control', 'placeholder' => __('crud.search')]) }}
    <x-icon class="fa-solid fa-search form-control-feedback pt-3"></x-icon>
</div>
<input type="hidden" name="m" value="{{ $mode }}" />
{!! Form::close() !!}
