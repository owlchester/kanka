@extends('layouts.app', [
    'title' => trans('settings.patreon.title'),
    'description' => trans('settings.patreon.description'),
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include('settings.menu', ['active' => 'patreon'])
        </div>
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('settings.patreon.title') }}
                    </h2>

                    @if(auth()->user()->hasRole('patreon'))
                        <p class="text-muted">{{ __('settings.patreon.linked') }}</p>

                        <p>{{ trans('settings.patreon.pledge', ['name' => auth()->user()->patreon_pledge ?: 'Kobold']) }}</p>
                    @else
                    <p class="text-muted">{{ __('settings.patreon.link') }}</p>

                        <a href="//www.patreon.com/oauth2/authorize?response_type=code&client_id={{ env('PATREON_CLIENT_ID') }}&redirect_uri={{ url('/settings/patreon-callback') }}" class="btn btn-primary">{{ __('settings.patreon.actions.link') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
