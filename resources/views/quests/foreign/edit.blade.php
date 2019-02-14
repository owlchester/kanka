@extends('layouts.app', [
    'title' => trans($name . '.edit.title', ['name' => $parent->name]),
    'description' => trans($name . '.edit.description'),
    'breadcrumbs' => [
        ['url' => route('quests.index'), 'label' => trans('quests.index.title')],
        ['url' => route('quests.show', $parent->id), 'label' => $parent->name],
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

                    {!! Form::model($model, ['method' => 'PATCH', 'route' => [$route . '.update', $parent->id, $model->id]]) !!}
                    @include($name . '._form')

                    {!! Form::hidden('quest_id', $parent->id) !!}

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

@include('editors.editor')