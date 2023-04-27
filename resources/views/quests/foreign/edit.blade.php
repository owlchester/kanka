@extends('layouts.app', [
    'title' => __($name . '.edit.title', ['name' => $parent->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests'))],
        ['url' => $parent->getLink(), 'label' => $parent->name],
        ['url' => $parent->getLink($menu), 'label' => __('quests.show.tabs.' . $menu)],
        __('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($model, [
                        'method' => 'PATCH',
                        'route' => [$route . '.update', $parent->id, $model->id],
                        'data-shortcut' => 1,
                    ]) !!}
                    @include($name . '._form')

                    {!! Form::hidden('quest_id', $parent->id) !!}

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
