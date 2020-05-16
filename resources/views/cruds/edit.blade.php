@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        ['url' => route($name . '.show', $model->id), 'label' => $model->name],
        trans('crud.update'),
    ],
    'canonical' => $model,
])
@inject('campaign', 'App\Services\CampaignService')


@section('header-extra')
    <div class="pull-right">
        @include('cruds.fields.save', ['disableCancel' => true])
    </div>
@endsection

@section('content')
    @include('partials.errors')

    {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => [$name . '.update', $model->id], 'data-shortcut' => '1']) !!}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ trans('crud.panels.entry') }}" data-toggle="tooltip">
                    {{ trans('crud.panels.entry') }}
                </a>
            </li>
            @include($name . '.form._tabs', ['source' => null])
            <li class="{{ (request()->get('tab') == 'permission' ? ' active' : '') }}">
                <a href="#form-permission" title="{{ trans('crud.panels.permission') }}" data-toggle="tooltip">
                    {{ trans('crud.panels.permission') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                @include($name . '.form._entry', ['source' => null])
            </div>
            @include($name . '.form._panes', ['source' => null])
            <div class="tab-pane {{ (request()->get('tab') == 'permission' ? ' active' : '') }}" id="form-permission">
                @include('crud.forms._permission', ['source' => null])
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@include('editors.editor')
