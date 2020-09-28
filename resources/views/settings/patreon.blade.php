@extends('layouts.app', [
    'title' => __('settings.patreon.title'),
    'description' => __('settings.patreon.description'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {{ __('settings.patreon.title') }}
            </h2>

            <p>
                {!! __('settings.patreon.benefits', [
                    'patreon' => link_to(config('patreon.url'), 'Patreon', ['target' => '_blank']),
                    'features' => link_to_route('front.features', __('settings.patreon.benefits_features'), '#paid-features', ['target' => '_blank'])
                ]) !!}
            </p>
        </div>
    </div>

    @if(auth()->user()->hasPatreonSync())
        @include('settings._' . strtolower(auth()->user()->patreon_pledge ?: 'kobold'))

    <div class="text-center">
        <button class="btn btn-danger" data-toggle="modal"
                data-target="#remove-patreon">{{ __('settings.patreon.remove.button') }}</button>
    </div>


    <div class="modal fade" id="remove-patreon" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('settings.patreon.remove.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p class="text-muted">
                        {{ __('settings.patreon.remove.text') }}
                    </p>
                    {!! Form::model(auth()->user(), ['method' => 'DELETE', 'route' => ['settings.patreon.unlink']]) !!}

                    <button class="btn btn-danger margin-bottom">
                        {{ __('crud.click_modal.confirm') }}
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-warning">
            <p>
                {!! __('settings.patreon.deprecated', ['subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))]) !!}
            </p>
        </div>
    @endif
@endsection
