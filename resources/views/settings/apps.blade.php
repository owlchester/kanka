@extends('layouts.app', [
    'title' => __('settings.apps.title'),
    'description' => '',
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-2 col-sm-4">
            @include('settings.menu', ['active' => 'apps'])
        </div>
        <div class="col-lg-10 col-sm-8">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('settings.apps.title') }}
                    </h2>

                    <p class="help-block">
                        {!! __('settings.apps.benefits') !!}
                    </p>

                    <hr />
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="float-left margin-r-5">
                                <i class="fab fa-discord fa-3x" style="color: rgb(114, 137, 218)"></i>
                            </div>
                            <strong>Discord</strong>
                            <p class="text-muted">
                                {{ __('settings.apps.discord.text') }}
                            </p>
                        </div>
                        <div class="col-xs-3 text-right">
                            @if(auth()->user()->apps()->app('discord')->first())
                                <span class="btn btn-default disabled">Already connected</span>
                            @else
                                <a href="https://discordapp.com/api/oauth2/authorize?client_id={{ config('discord.client_id') }}&redirect_uri={{ url('/settings/discord-callback') }}&response_type=code&scope=identify+guilds+guilds.join" class="btn btn-default">
                                    Connect
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
