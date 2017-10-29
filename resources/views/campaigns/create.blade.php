@extends('layouts.app', ['title' => trans('campaign.create.title'), 'description' => trans('campaign.create.description')])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a new Campaign</div>

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

                        <form method="POST" action="{{ route('campaigns.store') }}">
                            @include('campaigns._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
