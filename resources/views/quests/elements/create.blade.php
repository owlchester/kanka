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
    <x-form :action="['quests.quest_elements.store', $campaign, $quest->id]">
    <x-box>
        @include('partials.errors')

        @include('quests.elements._form')
        <x-dialog.footer>
            <input id="submit-mode" type="hidden" value="true"/>
            <div class="join">
                <button class="btn2 btn-primary join-item" id="form-submit-main">
                    {{ __('crud.save') }}
                </button>
                <div class="dropdown">
                    <button type="button" class="btn2 btn-primary join-item" data-dropdown aria-expanded="false">
                        <x-icon class="fa-regular fa-caret-down" />
                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                    </button>
                    <div class="dropdown-menu hidden" role="menu">
                        <x-dropdowns.item
                            link="#"
                            css="form-submit-actions">
                            {{ __('crud.save') }}
                        </x-dropdowns.item>
                        <x-dropdowns.item
                            link="#"
                            css="form-submit-actions"
                            :data="['action' => 'submit-update']">
                            {{ __('crud.save_and_update') }}
                        </x-dropdowns.item>
                        <x-dropdowns.item
                            link="#"
                            css="form-submit-actions"
                            :data="['action' => 'submit-new']">
                            {{ __('crud.save_and_new') }}
                        </x-dropdowns.item>
                    </div>
                </div>
            </div>
        </x-dialog.footer>
    </x-box>
    </x-form>
@endsection

@include('editors.editor')
