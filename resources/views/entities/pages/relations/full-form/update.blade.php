@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($langKey . '.update.title', ['name' => $relation->relation]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $langKey)],
        __('crud.update'),
    ],
    'centered' => true,
])

@section('fullpage-form')
    {!! Form::model($relation, [
    'method' => 'PATCH',
    'enctype' => 'multipart/form-data',
    'route' => ['relations.update', $campaign, $relation],
    'data-shortcut' => '1',
    'class' => 'entity-form',
    'id' => 'entity-form',
    'data-maintenance' => 1
    ]) !!}
@endsection

@section('content')
    @include('cruds.forms._errors')
    <div class="nav-tabs-custom">
        <div class="flex gap-2 items-center ">
            <div class="grow overflow-x-auto">
                <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                    <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>
                </ul>
            </div>
            @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form'])
        </div>
        <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
            <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
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
    @vite('resources/js/relations.js')
@endsection

@section('styles')
    @parent
    @vite('resources/sass/relations.scss')
@endsection
