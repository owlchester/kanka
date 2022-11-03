@extends('layouts.app', [
    'title' => trans('quests.elements.create.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => __('entities.quests')],
        ['url' => route('quests.show', $quest->id), 'label' => $quest->name],
        ['url' => route('quests.quest_elements.index', $quest->id), 'label' => __('quests.show.tabs.elements')],
        trans('crud.update'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            {!! Form::model($model, [
                'method' => 'PATCH',
                'route' => ['quests.quest_elements.update', $quest, $model->id],
                'data-shortcut' => 1,
            ]) !!}
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')
                    @include('quests.elements._form')
                </div>
                <div class="panel-footer">
                    @include('partials.footer_cancel')

                    <div class="pull-right">
                        <input id="submit-mode" type="hidden" value="true"/>
                        <div class="btn-group">
                            <button class="btn btn-success" id="form-submit-main">
                                {{ __('crud.save') }}
                            </button>
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li>
                                    <a href="#" class="dropdown-item form-submit-actions">
                                        {{ __('crud.save') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item form-submit-actions" data-action="submit-update">
                                        {{ __('crud.save_and_update') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item form-submit-actions" data-action="submit-new">
                                        {{ __('crud.save_and_new') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('quest-elements.keep-alive', $model->id) }}" />
    @endif
@endsection

@include('editors.editor')

@section('modals')
    @parent
    @if(!empty($editingUsers) && !empty($model))
        <div class="modal" id="entity-edit-warning" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">{{ __('entities/story.warning.editing.title') }}</h4>
                    </div>
                    <div class="modal-body modal-ajax-body">
                        <p>
                            {{ __('quests.elements.warning.editing.description') }}

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

                        <button type="button" class="btn btn-warning" id="entity-edit-warning-ignore" data-url="{{ route('quest-elements.confirm-editing', $model) }}">
                            {{ __('entities/story.warning.editing.ignore') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection