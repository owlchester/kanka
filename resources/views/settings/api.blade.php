@extends('layouts.app', [
    'title' => trans('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-body">

            <p class="text-muted">
                {{ __('settings.api.helper') }}<br />
                <a href="/docs/1.0" target="_blank"><i class="fa fa-external-link-alt"></i> {{ __('settings.api.link') }}</a>
            </p>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="box box-solid">
                <div class="box-body">

                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="box box-solid">
                <div class="box-body">

                    <passport-clients></passport-clients>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ mix('js/api.js') }}" defer></script>
@endsection
