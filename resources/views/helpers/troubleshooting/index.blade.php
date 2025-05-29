@extends('layouts.app', [
    'title' => __('helpers.troubleshooting.title'),
    'breadcrumbs' => false,
])

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="mb-3">{{ __('helpers.troubleshooting.subtitle') }}</h1>

        <x-form action="troubleshooting.generate">
        <x-box>
            <x-grid type="1/1">
                <p class="">
                    {{ __('helpers.troubleshooting.description') }}
                </p>

            @if($token)
                <x-alert type="success">
                    <x-grid type="1/1">
                        <p class="">{{ __('helpers.troubleshooting.success') }}</p>
                        <a href="#" data-clipboard="{{ $token }}" data-toggle="tooltip" data-toast="Token copied to the clipboard" data-title="{{__('campaigns.invites.actions.copy') }}">
                            <x-icon class="fa-regular fa-copy" />
                            {{ $token }}
                        </a>
                    </x-grid>
                </x-alert>
            @else
                <x-forms.field field="campaign" :label="__('entities/move.fields.campaign')">
                    <x-forms.select name="campaign" :options="$campaigns" class="w-full" />
                </x-forms.field>
            @endif

            @if(!$token)
                <div class=" text-right">
                    <input type="submit" class="btn2 btn-primary" value="{{ __('helpers.troubleshooting.save_btn') }}" />
                </div>
            @endif
            </x-grid>
        </x-box>
        </x-form>
    </div>
@endsection
