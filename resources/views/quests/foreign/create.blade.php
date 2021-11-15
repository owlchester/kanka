@extends('layouts.app', [
    'title' => trans($name . '.create.title', ['name' => $parent->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => trans('quests.index.title')],
        ['url' => route('quests.show', $parent->id), 'label' => $parent->name],
        ['url' => route('quests.' . $menu, $parent->id), 'label' => trans('quests.show.tabs.' . $menu)],
        trans('crud.create'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open([
                        'route' => [$route . '.store', $parent->id],
                        'method'=>'POST',
                        'data-shortcut' => 1,
                    ]) !!}
                    @include($name . '._form', ['mirror' => false])

                    {!! Form::hidden('quest_id', $parent->id) !!}

                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        @include('partials.or_cancel')
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('editors.editor')
