@extends('layouts.app', [
    'title' => __('assistance.title'),
    'breadcrumbs' => false,
])

@section('content')

    <div class="max-w-2xl mx-auto">
        <h1 class="mb-3">{{ __('helpers.troubleshooting.subtitle') }}</h1>

        <x-form action="troubleshooting.generate">
        <x-box class="rounded-2xl">
            <x-grid type="1/1">

            @if($token)
                <p class="">{!! __('assistance.success.opening', [
'discord' => '<a href="https://kanka.io/go/discord">Discord</a>'
]) !!}</p>
                <p>
                    <strong>{{ __('assistance.success.token') }}</strong><br />
                    <a href="#" data-clipboard="{{ $token }}" data-toggle="tooltip" data-toast="Token copied to the clipboard" data-title="{{__('campaigns.invites.actions.copy') }}">
                        <x-icon class="fa-regular fa-copy" />
                        {{ $token }}
                    </a>
                </p>

                <p>{{ __('assistance.success.secret') }}</p>
            @else
                    <x-helper>
                        <p class="">
                            {{ __('assistance.opening') }}
                        </p>
                        <p class="">
                            {{ __('assistance.select') }}
                        </p>
                    </x-helper>

                <x-forms.field field="campaign" :label="__('assistance.fields.campaign')">
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
