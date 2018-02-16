@extends('layouts.app', [
    'title' => trans('relations.edit.title', ['name' => $model->name]),
    'description' => trans('relations.edit.description'),
    'breadcrumbs' => [
        ['url' => route($parent . '.index'), 'label' => trans($parent . '.index.title')],
        ['url' => route($parent . '.show', $model->id), 'label' => $model->name],
        trans('crud.tabs.relations'),
        trans('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($relation, ['method' => 'PATCH', 'route' => [$route . '.update', $model->id, $relation->id], 'data-shortcut' => "1"]) !!}
                    @include('cruds.relations._form')

                    {!! Form::hidden('owner_id', $model->entity->id) !!}

                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '?tab=') === false ? '?tab=relation' : null))]) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
