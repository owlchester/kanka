@extends('layouts.app', [
    'title' => __('entities/notes.edit.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => trans($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        trans('crud.update'),
    ]
])

@section('fullpage-form')
    {!! Form::model($model, ['method' => 'PATCH', 'route' => ['entities.entity_notes.update', $entity->id, $model->id], 'data-shortcut' => '1', 'class' => 'entity-note-form', 'id' => 'entity-form']) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')


                    @include('cruds.notes._form')

                    @include('cruds.notes._saveOptions')
                </div>
            </div>
        </div>
    </div>
@endsection

@include('editors.editor')

@section('fullpage-form-end')
    @if(!empty($from))
        <input type="hidden" name="from" value="main" />
    @endif
    {!! Form::close() !!}
@endsection
