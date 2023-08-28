@extends('layouts.app', [
    'title' => __('quests.elements.create.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($quest->entity)->list(),
        Breadcrumb::show($quest),
        ['url' => route('quests.quest_elements.index', [$campaign, $quest->id]), 'label' => __('quests.show.tabs.elements')],
        __('crud.create'),
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open([
        'route' => ['quests.quest_elements.store', $campaign, $quest->id],
        'method'=>'POST',
        'data-shortcut' => 1,
        'data-maintenance' => 1,
    ]) !!}
    <x-box>
        @include('partials.errors')

        @include('quests.elements._form')
        <x-dialog.footer>
            <input id="submit-mode" type="hidden" value="true"/>
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
@endsection

@include('editors.editor')
