@if (!request()->ajax())<div id="datagrid-delete-forms">@endif
@foreach($models as $model)

    <x-form method="DELETE" :action="[$model->url('destroy'), method_exists($model, 'routeParams') ? $model->routeParams(['campaign' => $campaign] + $params) : [$campaign, $model]]" id="delete-form-{{ $model->id }}">
        @if ($model instanceof \App\Models\Relation)
            <input type="hidden" name="remove_mirrored" value="0" />
        @endif
    </x-form>
@endforeach
@if (!request()->ajax())</div>@endif
