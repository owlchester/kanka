@extends('layouts.app', [
    'title' => trans('settings.patreon.title'),
    'description' => trans('settings.patreon.description'),
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-2 col-sm-4">
            @include('settings.menu', ['active' => 'patreon'])
        </div>
        <div class="col-lg-6 col-sm-8">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('settings.patreon.title') }}
                    </h2>

                    <p>
                        {{ __('settings.patreon.benefits') }}
                    </p>
                    <p>
                        <a href="{{ config('patreon.url') }}" target="_blank">
                            {{ __('settings.patreon.actions.view') }} <i class="fas fa-external-link"></i>
                        </a>
                    </p>
                </div>
            </div>

            @if(auth()->user()->hasRole('patreon'))
                @include('settings._' . strtolower(auth()->user()->patreon_pledge ?: 'kobold'))
            @else
                <p class="text-muted">
                    {!! __('settings.patreon.link', ['patreon' => link_to(config('patreon.url'), 'Patreon', ['target' => '_blank'])]) !!}
                </p>

                <a href="//www.patreon.com/oauth2/authorize?response_type=code&client_id={{ config('patreon.client_id') }}&redirect_uri={{ url('/settings/patreon-callback') }}" class="btn btn-primary">{{ __('settings.patreon.actions.link') }}</a>
            @endif
        </div>
    </div>
@endsection
