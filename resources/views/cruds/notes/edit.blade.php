@extends('layouts.app', [
    'title' => __('entities/notes.edit.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => trans($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        trans('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

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

                    <div class="pull-right">
                        <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                           title="{{ __('crud.delete_modal.title') }}"
                           data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => $model->name]) }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-note-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                        </a>
                    </div>
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

@section('modals')


    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_notes.destroy', 'entity' => $entity, 'entity_note' => $model], 'style' => 'display:inline', 'id' => 'delete-form-note-' . $model->id]) !!}
    {!! Form::close() !!}
@endsection
