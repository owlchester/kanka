@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($langKey . '.update.title', ['name' => $relation->relation]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __($langKey . '.index.title')],
        __('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('fullpage-form')
    {!! Form::model($relation, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['relations.update', $relation], 'data-shortcut' => '1', 'class' => 'entity-form' . (isset($horizontalForm) && $horizontalForm ? ' form-horizontal' : null), 'id' => 'entity-form']) !!}
@endsection

@section('content')
    @include('cruds.forms._errors')

    <div class="nav-tabs-custom">
        <div class="pull-right">
            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
        </div>
        <ul class="nav nav-tabs">
            <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                <a href="#form-entry" title="{{ __('crud.panels.entry') }}">
                    {{ __('crud.panels.entry') }}
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
                {{ csrf_field() }}
                @include('entities.pages.relations.full-form._entry', ['source' => $source])
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@include('editors.editor')


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection


@section('scripts')
    @parent
    <script src="/vendor/spectrum/spectrum.js" defer></script>
    <script src="{{ mix('js/relations.js') }}" defer></script>
@endsection

@section('styles')
    @parent
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">
    <link href="{{ mix('css/relations.css') }}" rel="stylesheet">
@endsection
