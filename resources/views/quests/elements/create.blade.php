@extends('layouts.app', [
    'title' => __('quests.elements.create.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests'))],
        ['url' => $quest->getLink(), 'label' => $quest->name],
        ['url' => route('quests.quest_elements.index', $quest->id), 'label' => __('quests.show.tabs.elements')],
        __('crud.create'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')


@section('content')
    {!! Form::open([
        'route' => ['quests.quest_elements.store', $quest->id],
        'method'=>'POST',
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
@endsection

@include('editors.editor')
