@extends('layouts.app', [
    'title' => trans('campaigns.create.title'),
    'description' => trans('campaigns.create.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.create')
    ]
])

@section('content')
    <div class="row">
        <div class="{{ $start ? "col-lg-8 col-md-10 col-sm-12" : "col-md-12" }}">
            @include('partials.errors')

            {!! Form::open([
                'route' => ($start ? 'start' : 'campaigns.store'),
                'enctype' => 'multipart/form-data',
                'method' => 'POST',
                'data-shortcut' => '1'
            ]) !!}
                @include('campaigns._form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@include('editors.editor')
