@extends('layouts.app', ['title' => trans('campaigns.members.create.title', ['name' => $campaign->name]), 'description' => trans('campaigns.members.create.description')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('campaigns.members.create.title') }}
                </div>

                <div class="panel-body">
                    @include('partials.errors')


                    {!! Form::open(array('route' => 'campaign_relation.store', 'method'=>'POST')) !!}
                    @include('campaigns.members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
