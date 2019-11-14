@if ($model->type)
    <li class="list-group-item">
        <b>{{ trans('crud.fields.type') }}</b> <span class="pull-right">{{ $model->type }}</span>
        <br class="clear" />
    </li>
@endif