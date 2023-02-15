@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('crud.edit')
    ],
    'canonical' => true,
])

@section('fullpage-form')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['update', $campaign],
        'data-shortcut' => '1',
        'class' => 'entity-form',
        'data-unload' => 1,
    ]) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))

    @if(!empty($model) && $model->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('campaign.keep-alive', [$model]) }}" />
    @endif
@endsection


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
