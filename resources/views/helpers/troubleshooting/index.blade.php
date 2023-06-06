@extends('layouts.app', [
    'title' => __('helpers.troubleshooting.title'),
    'breadcrumbs' => false,
])

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="mb-3">{{ __('helpers.troubleshooting.subtitle') }}</h1>

        {!! Form::open(['route' => 'troubleshooting.generate', 'method' => 'POST']) !!}
        <x-box>
            <p class="mb-5">
                {{ __('helpers.troubleshooting.description') }}
            </p>

            @if($token)
                <x-alert type="success">
                    <p class="mb-5">{{ __('helpers.troubleshooting.success') }}</p>
                    <a href="#" data-clipboard="{{ $token }}" data-toggle="tooltip" data-toast="Token copied to the clipboard" title="{{__('campaigns.invites.actions.copy') }}">
                        <i class="fa-solid fa-copy" aria-hidden="true"></i>
                        {{ $token }}
                    </a>
                </x-alert>
            @else
                <div class="field-campaign mb-5">
                    <label>{{ __('entities/move.fields.campaign') }}</label>
                    {!! Form::select('campaign', $campaigns, null, ['class' => 'form-control']) !!}
                </div>
            @endif

            @if(!$token)
                <div class=" text-right">
                    <input type="submit" class="btn2 btn-primary" value="{{ __('helpers.troubleshooting.save_btn') }}" />
                </div>
            @endif
        </x-box>
        {!! Form::close() !!}
    </div>
@endsection
