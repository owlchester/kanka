@extends('layouts.app', [
    'title' => __('quests.elements.edit.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests'))],
        ['url' => $quest->getLink(), 'label' => $quest->name],
        ['url' => route('quests.quest_elements.index', $quest->id), 'label' => __('quests.show.tabs.elements')],
        __('crud.update'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'route' => ['quests.quest_elements.update', $quest, $model->id],
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
    <x-box>
        @include('partials.errors')
        @include('quests.elements._form')
        <x-box.footer>
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
        </x-box.footer>
    </x-box>
    {!! Form::close() !!}
    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('quest-elements.keep-alive', $model->id) }}" />
    @endif
@endsection

@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
