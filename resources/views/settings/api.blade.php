@extends('layouts.app', [
    'title' => trans('settings.api.title'),
    'description' => trans('settings.api.description'),
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('settings.menu', ['active' => 'api'])
        </div>
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('settings.api.title') }}
                    </h2>

                    <p class="text-muted">{{ trans('settings.api.help') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
