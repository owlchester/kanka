@extends('layouts.app', [
    'title' => trans('campaigns.roles.edit.title', ['name' => $role->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => $role->campaign->name],
        ['url' => route('campaign_roles.index'), 'label' => trans('campaigns.show.tabs.roles')]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['campaign_roles.update', $role->id], 'data-shortcut' => "1"]) !!}
                    @include('campaigns.roles._form')

                    {!! Form::hidden('campaign_id', $model->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
