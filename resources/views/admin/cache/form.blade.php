@extends('layouts.admin', [
    'title' => __('admin/cache.title'),
    'breadcrumbs' => [
        ['url' => route('admin.cache'), 'label' => __('admin/cache.title')]
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => 'admin.cache.destroy','method' => 'DESTROY', 'data-shortcut' => '1']) !!}
    <div class="form-group required">
        <label>{{ __('admin/cache.fields.key') }}</label>
        {!! Form::text('key', old('key'), ['class' => 'form-control html-editor', 'name' => 'key']) !!}
    </div>

    <button class="btn btn-danger" id="form-submit-main">{{ __('crud.remove') }}</button>
    {!! Form::close() !!}
@endsection
