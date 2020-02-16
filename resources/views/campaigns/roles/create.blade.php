@extends('layouts.app', [
    'title' => trans('campaigns.roles.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => $model->name],
        ['url' => route('campaign_roles.index'), 'label' => trans('campaigns.show.tabs.roles')],
        __('campaigns.roles.actions.add')
    ],
    'mainTitle' => false,
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => ['campaign_roles.store'], 'method'=>'POST', 'data-shortcut' => "1")) !!}
                    @include('campaigns.roles._form')

                    {!! Form::hidden('campaign_id', CampaignLocalization::getCampaign()->id) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
