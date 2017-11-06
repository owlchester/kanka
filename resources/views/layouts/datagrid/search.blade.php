{!! Form::open(['url' => $route, 'method' => 'GET', 'class' => 'form-inline pull-right datagrid-search']) !!}
<div class="input-group input-group-sm" style="width: 150px;">
    {{ Form::text('search', request('search'), ['class' => 'form-control input-sm', 'placeholder' => trans('crud.search')]) }}
    <div class="input-group-btn">
        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
    </div>
</div>
{!! Form::close() !!}