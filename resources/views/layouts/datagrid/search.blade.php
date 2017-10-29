{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'form-inline pull-right datagrid-search']) !!}
    <label>
        Search
        {{ Form::text('search', request('search'), ['class' => 'form-control input-sm']) }}
    </label>
{!! Form::close() !!}