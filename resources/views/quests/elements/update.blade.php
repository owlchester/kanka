@extends('layouts.app', [
    'title' => __('quests.elements.edit.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($quest->entity)->list(),
        Breadcrumb::show($quest),
        ['url' => route('quests.quest_elements.index', [$campaign, $quest->id]), 'label' => __('quests.show.tabs.elements')],
        __('crud.update'),
    ]
])

@section('content')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'route' => ['quests.quest_elements.update', $campaign, $quest, $model->id],
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
    <x-box>
        @include('partials.errors')
        @include('quests.elements._form')
        <x-dialog.footer>
            <div class="join">
                <button class="btn2 btn-primary join-item" id="form-submit-main">
                    {{ __('crud.save') }}
                </button>
                <div class="dropdown dropdown-menu-right">
                    <button type="button" class="btn2 btn-primary dropdown-toggle join-item" data-toggle="dropdown" aria-expanded="false">
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
        </x-dialog.footer>
    </x-box>
    {!! Form::close() !!}
    @if(!empty($model) && $campaign->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('quest-elements.keep-alive', [$campaign, $model->id]) }}" />
    @endif
@endsection

@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
