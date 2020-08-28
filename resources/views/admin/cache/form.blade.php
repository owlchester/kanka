@extends('layouts.admin', [
    'title' => __('admin/cache.title'),
    'breadcrumbs' => [
        ['url' => route('admin.cache'), 'label' => __('admin/cache.title')]
    ]
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-6">
            {!! Form::open(['route' => 'admin.cache.view','method' => 'POST', 'data-shortcut' => '1']) !!}
            <div class="form-group required">
                <label>{{ __('admin/cache.fields.key') }}</label>
                {!! Form::text('key', old('key'), ['class' => 'form-control html-editor', 'name' => 'key']) !!}
            </div>

            <button class="btn btn-primary" id="form-submit-main">{{ __('crud.view') }}</button>
            {!! Form::close() !!}

            @if (isset($val))
                <div class="alert alert-success">
                    <p>{{ $key }}</p>
                    <p>@dump($val)</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">

            {!! Form::open(['route' => 'admin.cache.destroy','method' => 'DELETE', 'data-shortcut' => '1']) !!}
            <div class="form-group required">
                <label>{{ __('admin/cache.fields.key') }}</label>
                {!! Form::text('key', old('key'), ['class' => 'form-control html-editor', 'name' => 'key']) !!}
            </div>

            <button class="btn btn-danger" id="form-submit-main">{{ __('crud.remove') }}</button>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
