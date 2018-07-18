@extends('layouts.app', [
    'title' => trans('campaigns.create.title'),
    'description' => trans('campaigns.create.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.create')
    ]
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @if (!session()->has('campaign_id'))
                <div class="callout callout-info">
                    <h4>{{ trans('campaigns.create.helper.title', ['name' => config('app.name')]) }}</h4>

                    <p>{!! trans('campaigns.create.helper.first') !!}</p>
                    <p>{{ trans('campaigns.create.helper.second') }}</p>
                </div>
            @endif
            @include('partials.errors')

            {!! Form::open(array('route' => (!empty($start) ? 'start' : 'campaigns.store'), 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                @include('campaigns._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('layouts.widgets.tinymce')
