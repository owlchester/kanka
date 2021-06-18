@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.update.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
    ]
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('entities/entry.update.title', ['name' => $entity->name]) }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($entity->child, ['route' => ['entities.entry.update', $entity], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}


            <div class="form-group">
                {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
            </div>

            <div class="form-group">
                <button class="btn btn-success">{{ __('crud.update') }}</button>
                @if (!request()->ajax())
                    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
                @endif
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('editors.editor')
