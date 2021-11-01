@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.roles.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_roles.index'), 'label' => __('campaigns.show.tabs.roles')],
        __('campaigns.roles.actions.add')
    ],
    'mainTitle' => false,
])

@section('content')
    {!! Form::open(['route' => ['campaign_roles.store'], 'method' => 'POST', 'data-shortcut' => 1, 'class' => 'entity-form']) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">
            {!! __('campaigns.roles.create.title') !!}
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
    {!! Form::hidden('campaign_id', CampaignLocalization::getCampaign()->id) !!}

    {!! Form::close() !!}
@endsection
