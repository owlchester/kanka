@extends('layouts.app', ['title' => trans('campaigns.edit.title', ['campaign' => $campaign->name]), 'description' => trans('campaigns.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">Edit {{ $campaign->name }}</div>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif

                    {!! Form::model($campaign, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['campaigns.update', $campaign->id]]) !!}
                        @include('campaigns._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
