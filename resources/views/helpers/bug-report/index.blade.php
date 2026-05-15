@extends('layouts.app', [
    'title' => __('bug-report.title'),
    'breadcrumbs' => false,
])

@section('content')

    <div class="max-w-2xl mx-auto flex flex-col gap-4 ">
        <h1 class="text-2xl">{{ __('bug-report.title') }}</h1>

        <x-box class="rounded-2xl">
            <x-grid type="1/1">
                <x-helper>
                    <p>{!! __('bug-report.intro') !!}</p>
                </x-helper>

                <div class="flex flex-col gap-3">
                    <a href="https://kanka.io/go/discord" target="_blank" rel="noopener" class="btn2 btn-primary">
                        <x-icon class="fa-brands fa-discord" />
                        {{ __('bug-report.discord') }}
                    </a>
                    <a href="mailto:{{ config('app.email') }}" class="btn2">
                        <x-icon class="fa-regular fa-envelope" />
                        {{ config('app.email') }}
                    </a>
                </div>
            </x-grid>
        </x-box>
    </div>
@endsection
