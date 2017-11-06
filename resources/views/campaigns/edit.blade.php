@extends('layouts.app', ['title' => trans('campaigns.edit.title', ['campaign' => $campaign->name]), 'description' => trans('campaigns.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($campaign, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['campaigns.update', $campaign->id]]) !!}
                        @include('campaigns._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
