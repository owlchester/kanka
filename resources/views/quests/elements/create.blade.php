@extends('layouts.app', [
    'title' => trans('quests.elements.create.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => trans('quests.index.title')],
        ['url' => route('quests.show', $quest->id), 'label' => $quest->name],
        ['url' => route('quests.quest_elements.index', $quest->id), 'label' => __('quests.show.tabs.elements')],
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
                        'route' => ['quests.quest_elements.store', $quest->id],
                        'method'=>'POST',
                        'data-shortcut' => 1,
                    ]) !!}
                    @include('quests.elements._form')

                    <div class="form-group">
                        <button class="btn btn-success">{{ __('crud.save') }}</button>

                        @include('partials.or_cancel')
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@include('editors.editor')
