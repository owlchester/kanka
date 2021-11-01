@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('campaigns.roles.edit.title', ['name' => $role->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_roles.index'), 'label' => trans('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
])

@section('content')
    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['campaign_roles.update', $role->id], 'data-shortcut' => 1, 'class' => 'entity-form']) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">
            {!! __('campaigns.roles.edit.title', ['name' => $role->name]) !!}
        </h4>
    </div>
    <div class="modal-body">
        @include('partials.errors')

        @include('campaigns.roles._form')
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
            {{ __('crud.cancel') }}
        </button>

        <button class="btn btn-success">{{ __('campaigns.roles.actions.save') }}</button>
    </div>
    {!! Form::hidden('campaign_id', $model->id) !!}
    {!! Form::close() !!}
@endsection
