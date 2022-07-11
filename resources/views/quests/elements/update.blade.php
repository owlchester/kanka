@extends('layouts.app', [
    'title' => trans('quests.elements.create.title', ['name' => $quest->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('quests'), 'label' => trans('quests.index.title')],
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
                        <button class="btn btn-success">
                            <i class="fa-solid fa-save" aria-hidden="true"></i>
                            {{ __('crud.save') }}
                        </button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('editors.editor')
