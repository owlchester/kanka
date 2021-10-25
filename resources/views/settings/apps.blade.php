<?php /** @var \App\Models\UserApp $discord */?>
@extends('layouts.app', [
    'title' => __('settings.apps.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('settings.apps.title') }}
            </h3>
        </div>
        <div class="box-body">
            <p class="help-block">
                {!! __('settings.apps.benefits') !!}
            </p>

            <hr />
            <div class="row">
                <div class="col-xs-12">
                    @if($discord = auth()->user()->apps()->app('discord')->first())
                        <button class="pull-right btn btn-default delete-confirm" data-toggle="modal" data-name="Discord"
                                data-target="#delete-confirm" data-delete-target="delete-form-discord"
                                title="{{ __('settings.apps.actions.remove') }}">
                            {{ __('settings.apps.actions.remove') }} @if (!empty($discord->settings)) {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }} @endif
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => [
                                'settings.discord.destroy'
                            ],
                            'style' => 'display:inline',
                            'id' => 'delete-form-discord'
                        ]) !!}
                        {!! Form::close() !!}
                    @else
                        <a href="https://discord.com/api/oauth2/authorize?client_id={{ config('discord.client_id') }}&redirect_uri={{ url('/settings/discord-callback') }}&response_type=code&scope=identify+guilds+guilds.join" class="btn btn-default pull-right">
                            {{ __('settings.apps.actions.connect') }}
                        </a>
                    @endif

                    <div class="pull-left margin-r-5">
                        <i class="fab fa-discord fa-3x" style="color: rgb(114, 137, 218)"></i>
                    </div>
                    <strong>Discord</strong>
                    <p class="text-muted">
                        {{ __('settings.apps.discord.text') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
