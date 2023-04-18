@extends('layouts.app', [
    'title' => __('helpers.troubleshooting.title'),
    'breadcrumbs' => false,
])

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="mb-3">{{ __('helpers.troubleshooting.subtitle') }}</h1>

        {!! Form::open(['route' => 'troubleshooting.generate', 'method' => 'POST']) !!}
        <div class="rounded shadow-xs p-4 bg-box">
            <p class="mb-5">
                {{ __('helpers.troubleshooting.description') }}
            </p>

            @if($token)
                <div class="alert alert-success">
                    <p class="mb-5">{{ __('helpers.troubleshooting.success') }}</p>
                    <a href="#" data-clipboard="{{ $token }}" data-toggle="tooltip" data-toast="Token copied to the clipboard" title="{{__('campaigns.invites.actions.copy') }}">
                        <i class="fa-solid fa-copy" aria-hidden="true"></i>
                        {{ $token }}
                    </a>
                </div>
            @else
                <div class="form-group">
                    <label>{{ __('entities/move.fields.campaign') }}</label>
                    {!! Form::select('campaign', $campaigns, null, ['class' => 'form-control']) !!}
                </div>
            @endif

            @if(!$token)
                <div class=" text-right">
                    <input type="submit" class="btn btn-primary" value="{{ __('helpers.troubleshooting.save_btn') }}" />
                </div>
            @endif
        </div>
        {!! Form::close() !!}
    </div>
@endsection
