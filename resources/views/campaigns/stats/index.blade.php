<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns/stats.title2') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.stats')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    @include('ads.top')

    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 items-center justify-between">
            <h1 class="text-2xl">
                {!! __('campaigns/stats.title2') !!}
            </h1>
        </div>

            <p>
                {{ __('campaigns/stats.tutorial', ['amount' => 24]) }}
            </p>

        <x-grid>

            <div class="flex flex-col gap-5 stats-entities">
                <h3 class="text-xl">{{ __('campaigns.show.tabs.modules') }}</h3>
                <x-box>
                    <div class="grid grid-cols-2 gap-2 items-center">
                        <div class="entity-total font-bold">
                            {{ __('entities.entities') }}
                        </div>
                        <div class="entity-count font-bold">
                            {{ number_format($stats['entities']) }}
                        </div>
                        <hr class="col-span-2" />
                        @foreach ($stats['types'] as $type => $count)
                            @if (!\Illuminate\Support\Arr::has($entityTypes, $type))
                                @continue
                            @endif
                            <div class="entity-type" data-type="{{ $type }}">
                                {{ $entityTypes[$type]->plural() }}
                            </div>
                            <div class="entity-count">
                                {!! number_format($count) !!}
                            </div>
                        @endforeach
                    </div>
                </x-box>
            </div>

            <div class="flex flex-col gap-5">
                <div class="flex flex-col gap-5 stats-modules">
                    <h3 class="text-xl">{{ __('campaigns/modules.sections.features') }}</h3>
                    <x-box>
                        <div class="grid grid-cols-2 gap-2 items-center">
                            @foreach ($stats['modules'] as $module => $count)
                                <div class="module-type" data-type="{{ $module }}">
                                    {{ __('entities.' . $module) }}
                                </div>
                                <div class="entity-count">
                                    {!! number_format($count) !!}
                                </div>
                            @endforeach
                        </div>
                    </x-box>
                </div>

                <div class="flex flex-col gap-5 stats-permissions">
                    <h3 class="text-xl">{{ __('campaigns/stats.fields.general') }}</h3>
                    <x-box>
                        <div class="grid grid-cols-2 gap-2 items-center">
                            @if ($campaign->creator)
                                <div class="permission-name">
                                    {{ __('campaigns/stats.fields.creator') }}
                                </div>
                                <div class="permission-count">
                                    <a href="{{ route('users.profile', [$campaign->creator->id]) }}">
                                        {!! $campaign->creator->name !!}
                                    </a>
                                </div>
                            @endif
                            <div class="permission-name">
                                {{ __('campaigns/stats.fields.created') }}
                            </div>
                            <div class="permission-count">
                                {{ $campaign->created_at->isoFormat('MMMM D, Y') }}
                            </div>
                            <div class="permission-name">
                                {{ __('campaigns.fields.followers') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format($stats['permissions']['followers']) }}
                            </div>
                            <div class="permission-name">
                                {{ __('campaigns.show.tabs.members') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format($stats['permissions']['users']) }}
                            </div>
                            <div class="permission-name">
                                {{ __('campaigns.show.tabs.roles') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format($stats['permissions']['roles']) }}
                            </div>

                            <div class="permission-name">
                                {{ __('campaigns/stats.fields.words') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format(\Illuminate\Support\Arr::get($stats, 'words.total', 0)) }}
                            </div>

                            <div class="permission-name">
                                {{ __('campaigns/stats.fields.from-entities') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format(\Illuminate\Support\Arr::get($stats, 'words.entities', 0)) }}
                            </div>
                            <div class="permission-name">
                                {{ __('campaigns/stats.fields.from-posts') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format(\Illuminate\Support\Arr::get($stats, 'words.posts', 0)) }}
                            </div>
                            <div class="permission-name">
                                {{ __('campaigns/stats.fields.from-elements') }}
                            </div>
                            <div class="permission-count">
                                {{ number_format(\Illuminate\Support\Arr::get($stats, 'words.elements', 0)) }}
                            </div>
                        </div>
                    </x-box>
                </div>
            </div>
        </x-grid>
    </div>
@endsection
