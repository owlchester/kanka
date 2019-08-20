@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.update')
    ]
])

@section('fullpage-form')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['campaigns.update', $model->id],
        'data-shortcut' => '1'
    ]) !!}
@endsection

@section('header-extra')
    <div class="pull-right">
        @include('cruds.fields.save', ['onlySave' => true, 'disableCancel' => true, 'target' => 'entity-form'])
    </div>
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))
@endsection


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@include('editors.editor')

@section('scripts')
    @parent
    <script src="{{ mix('js/campaign.js') }}" defer></script>
@endsection