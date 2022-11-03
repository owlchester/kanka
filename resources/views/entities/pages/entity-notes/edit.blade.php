@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/notes.edit.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => __('entities.' . $parentRoute)],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        __('crud.update'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')

@section('fullpage-form')
    {!! Form::model($model, ['method' => 'PATCH', 'route' => ['entities.entity_notes.update', $entity->id, $model->id], 'data-shortcut' => '1', 'class' => 'entity-note-form entity-form', 'id' => 'entity-form']) !!}
@endsection

@section('content')

    @include('entities.pages.entity-notes._form')

    <div class="mt-5 text-right">
        <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
           title="{{ __('crud.delete_modal.title') }}"
           data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-note-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
            <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
        </a>
    </div>

    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('posts.keep-alive', ['entity_note' => $model, 'entity' => $entity]) }}" />
    @endif
@endsection

@include('editors.editor')

@section('fullpage-form-end')
    @if(!empty($from))
        <input type="hidden" name="from" value="main" />
    @endif
    {!! Form::close() !!}
@endsection

@section('modals')
    @parent
    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_notes.destroy', 'entity' => $entity, 'entity_note' => $model], 'style' => 'display:inline', 'id' => 'delete-form-note-' . $model->id]) !!}
    {!! Form::close() !!}

    @if(!empty($editingUsers) && !empty($model))
        <div class="modal" id="entity-edit-warning" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ __('entities/story.warning.editing.title') }}</h4>
                    </div>
                    <div class="modal-body modal-ajax-body">
                        <p>
                            {{ __('entities/notes.warning.editing.description') }}

                        </p>
                        <ul>
                            @foreach ($editingUsers as $user)
                                <li class="user-id-{{ $user->id }}">{{ __('entities/story.warning.editing.user', ['user' => $user->name, 'since' => \Carbon\Carbon::createFromTimeString($user->pivot->created_at)->diffForHumans()]) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-body modal-spinner-body text-center" style="display: none">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" id="entity-edit-warning-back" data-url="{{ url()->previous() }}">
                            {{ __('entities/story.warning.editing.back') }}
                        </button>

                        <button type="button" class="btn btn-warning" id="entity-edit-warning-ignore" data-url="{{ route('posts.confirm-editing', ['entity_note' => $model, 'entity' => $entity]) }}">
                            {{ __('entities/story.warning.editing.ignore') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
