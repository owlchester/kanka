@extends('layouts.app', [
    'title' => trans($name . '.create.title', ['name' => $parent->name]),
    'description' => trans($name . '.create.description'),
    'breadcrumbs' => [
        ['url' => route('quests.index'), 'label' => trans('quests.index.title')],
        ['url' => route('quests.show', $parent->id), 'label' => $parent->name],
        trans('crud.tabs.relations'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => [$route . '.store', $parent->id], 'method'=>'POST')) !!}
                    @include($name . '._form', ['mirror' => false])

                    {!! Form::hidden('quest_id', $parent->id) !!}

                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.widgets.tinymce')