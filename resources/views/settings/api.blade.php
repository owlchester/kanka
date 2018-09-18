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
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('settings.api.title') }}
                    </h2>

                    @if(auth()->user()->hasRole('api'))
                    <p class="text-muted">{{ __('settings.api.experimental') }}</p>
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    @else
                    <p class="text-muted">{{ __('settings.api.request_permission') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
