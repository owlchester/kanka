@extends('layouts.app', [
    'title' => __('settings.patreon.title'),
    'description' => __('settings.patreon.description'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    <div class="max-w-4xl">
        <h1 class="mb-3">
            {{ __('settings.patreon.title') }}
        </h1>
        @include('partials.errors')

        @if(auth()->user()->isLegacyPatron())
            @includeIf('settings.tiers._' . strtolower(auth()->user()->pledge ?: 'kobold'))

            <div class="text-center">
                <button class="btn btn-danger" data-toggle="modal"
                        data-target="#remove-patreon">{{ __('settings.patreon.remove.button') }}</button>
            </div>
        @else
            <div class="alert alert-warning">
                <p>
                    {!! __('settings.patreon.deprecated', ['subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))]) !!}
                </p>
            </div>
        @endif
    </div>
@endsection

@section('modals')
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

                    <button class="btn btn-danger mb-5">
                        {{ __('crud.click_modal.confirm') }}
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
