@extends('layouts.app', [
    'title' => trans('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {{ trans('settings.api.title') }}
            </h2>

            <p class="text-muted">
                {{ __('settings.api.experimental') }}<br />
                <a href="/docs/1.0" target="_blank"><i class="fa fa-external-link-alt"></i> {{ __('settings.api.link') }}</a>
            </p>
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ mix('js/api.js') }}" defer></script>
@endsection
