@extends('layouts.app', [
    'title' => trans('campaigns.create.title'),
    'description' => trans('campaigns.create.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.title')],
        trans('crud.create')
    ]
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Create a new Campaign</div>

        <div class="panel-body">
            @if (!session()->has('campaign_id'))
                <div class="callout callout-info">
                    <h4>Welcome to {{ config('app.name') }}!</h4>

                    <p>Thanks for trying our app out! Before we can go any further, we need you to provide one simple thing for us, your <b>campaign name</b>. This is the name of your world that separates it from others, so it has to be unique. If you don't have a good name yet, don't worry, you can <b>always change it later</b>, or create more campaigns.</p>
                    <p>But enough chit-chat! So, what's it going to be?</p>
                </div>
            @endif
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

            {!! Form::open(array('route' => 'campaigns.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                @include('campaigns._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
