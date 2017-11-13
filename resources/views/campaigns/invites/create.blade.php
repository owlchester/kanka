@extends('layouts.app', ['title' => trans('campaigns.invites.create.title', ['name' => $campaign->name]), 'description' => trans('campaigns.invites.create.description')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => ['campaigns.campaign_invites.store', 'campaign' => $campaign->id], 'method'=>'POST')) !!}
                    @include('campaigns.invites._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
