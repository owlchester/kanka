@if (!request()->ajax())<div id="datagrid-delete-forms">@endif
@foreach($models as $model)
    {!! Form::open(['method' => 'DELETE', 'route' => [$model->url('destroy'), method_exists($model, 'routeParams') ? $model->routeParams(['campaign' => $campaign] + $params) : [$campaign, $model]], 'style '=> 'display:inline', 'id' => 'delete-form-' . $model->id]) !!}
        @if ($model instanceof \App\Models\Relation)
            <input type="hidden" name="remove_mirrored" value="0" />
        @endif
        {!! Form::close() !!}
@endforeach
@if (!request()->ajax())</div>@endif
