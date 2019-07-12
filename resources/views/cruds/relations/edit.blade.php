@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('relations.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parent . '.index'), 'label' => trans($parent . '.index.title')],
        ['url' => route($parent . '.show', $model->id), 'label' => $model->name],
        trans('crud.tabs.relations'),
        trans('crud.update'),
    ]
])
@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ __('relations.edit.title', ['name' => $model->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            @include('cruds.forms._errors')

            {!! Form::model($relation, ['method' => 'PATCH', 'route' => [$route . '.update', $model->id, $relation->id],
                'data-shortcut' => 1, 'id' => 'relation-form'
            ]) !!}
            @include('cruds.relations._form')

            {!! Form::hidden('owner_id', $model->entity->id) !!}

            <div class="form-group">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                @if (!$ajax){!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '#relation') === false ? '#relation' : null))]) !!}@endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
