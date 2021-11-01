@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.update.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.story'),
        __('crud.edit')
    ],
    'mainTitle' => false,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')

    {!! Form::model($entity->child, ['route' => ['entities.entry.update', $entity], 'method' => 'PATCH', 'data-shortcut' => 1, 'class' => 'entity-form entity-entry-form']) !!}

    <div class="box box-solid">
        @if (request()->ajax())
            <div class="box-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('entities/entry.update.title', ['name' => $entity->name]) }}
                </h4>
            </div>
        @endif
        <div class="box-body">
            @include('partials.errors')


            <div class="form-group">
                {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button class="btn btn-success">{{ __('crud.update') }}</button>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-default">
                {{ __('crud.cancel') }}
            </a>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@include('editors.editor')
