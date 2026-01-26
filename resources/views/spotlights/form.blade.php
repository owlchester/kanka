<?php /** @var ?\App\Models\SpotlightContent $content */?>
@extends('layouts.front', [
    'title' => __('spotlights.form.title') . ' - ' . $campaign->name,
    'skipPerf' => true,
])

@section('content')

    <section class="bg-purple text-white gap-16">
        <div class="px-6 py-20 lg:max-w-7xl mx-auto flex flex-col gap-8">
            <div class="flex gap-10">
                <div class="grow flex flex-col gap-3 max-w-2xl">
                    <h1 class="">{{ __('spotlights.form.title') }}</h1>

                    <p class="text-light">
                        {!! __('spotlights.form.preset', ['campaign' => '<strong>' . $campaign->name . '</strong>']) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-5 max-w-7xl mx-auto text-dark flex flex-col gap-10">
        @if (!$campaign->isPublic())
            <div class="p-5 rounded bg-orange-300 text-black">
                <p>{{ __('spotlights.form.not-public') }}</p>
            </div>
        @else
            @if ($content?->isApplied())
            <div class="bg-light rounded-2xl p-6 flex flex-col gap-4">
                <h2 class="text-lg font-bold">{{ __('spotlights.applied.title') }}</h2>
                <p class="text-dark">{{ __('spotlights.applied.description') }}</p>
                <form method="POST" action="{{ route('spotlights.retract', ['campaign' => $campaign]) }}">
                    @csrf
                    <button type="submit" class="rounded p-2 bg-red-400 text-white cursor-pointer">{{ __('spotlights.applied.actions.retract') }}</button>
                </form>
            </div>
            @elseif ($content?->isApproved())
                <div class="bg-light rounded-2xl p-6 flex flex-col gap-4">
                    <h2 class="text-lg font-bold">{{ __('spotlights.approved.title') }}</h2>
                    <p class="text-dark">{!! __('spotlights.approved.description', ['spotlight' => '<a href="' . \App\Facades\Domain::toFront('spotlight') . '" class="underline">Spotlight</a>']) !!}</p>
                </div>
            @elseif ($content?->isRejected())
                <div class="bg-light rounded-2xl p-6 flex flex-col gap-4">
                    <h2 class="text-lg font-bold">{{ __('spotlights.rejected.title') }}</h2>
                    <p class="text-dark">{{ __('spotlights.rejected.description') }}</p>
                </div>
            @endif
            <form class="flex flex-col gap-10" method="POST" action="{{ route('spotlights.save', ['campaign' => $campaign]) }}">
                @csrf

                @if ($errors->any() || session('error'))
                    <div class="rounded-2xl p-4 bg-red-400 text-white flex flex-col gap-1">
                        <strong>{{ __('partials.errors.title') }}</strong>
                        <span>{{ __('partials.errors.description') }}</span>

                        @if (session('error')) {!! session('error') !!} @endif
                    </div>
                @endif

                @include('spotlights.field', ['field' => 'time'])
                @include('spotlights.field', ['field' => 'world'])
                @include('spotlights.field', ['field' => 'proud'])
                @include('spotlights.field', ['field' => 'inspiration'])
                @include('spotlights.field', ['field' => 'stories'])
                @include('spotlights.field', ['field' => 'kanka'])

                @if (empty($content) || $content->isDraft())
                <div class="flex items-center justify-between">
                    <p class="text-purple">
                        {{ __('spotlights.form.draft') }}
                    </p>
                    <div class="flex items-center gap-2">

                        <button type="submit" class="btn2 btn-primary">{{ __('spotlights.form.actions.save') }}</button>
                        @if ($content)
                            <button type="submit" class="btn2 btn-primary" name="action" value="apply">
                                {{ __('spotlights.form.actions.apply') }}
                            </button>
                        @endif
                    </div>
                </div>
                @endif
            </form>
        @endif
    </section>
@endsection
