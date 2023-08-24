<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.default-images') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.default-images')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'default-images'])
        </div>
        <div class="grow max-w-4xl flex flex-col gap-5">
            <div class="flex gap-2 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.default-images') }}
                </h3>
                @if ($campaign->boosted())
                    <a href="https://docs.kanka.io/en/latest/features/campaigns/default-thumbnails.html" class="btn2 btn-sm btn-ghost" target="_blank">
                        <x-icon class="question"></x-icon>
                        {{ __('crud.actions.help') }}
                    </a>

                    <a href="{{ route('campaign.default-images.create', $campaign) }}" class="btn2 btn-primary btn-sm"
                       data-toggle="dialog-ajax" data-target="new-thumbnail"
                       data-url="{{ route('campaign.default-images.create', $campaign) }}">
                        <x-icon class="plus"></x-icon>
                        {{ __('campaigns/default-images.actions.add') }}
                    </a>
                @endif
            </div>
            @if ($campaign->boosted())
                    @if (empty($campaign->defaultImages()))
                        <x-box>
                            <a href="{{ route('campaign.default-images.create', $campaign) }}" class="btn2 btn-primary"
                               data-toggle="dialog-ajax" data-target="new-thumbnail"
                               data-url="{{ route('campaign.default-images.create', $campaign) }}">
                                <x-icon class="plus"></x-icon>
                                {{ __('campaigns/default-images.actions.add') }}
                            </a>
                        </x-box>
                    @endif
                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-4 md:grid-cols-2 md:gap-5">

                        @foreach ($campaign->defaultImages() as $image)
                            <div class="rounded overflow-hidden border flex gap-2 items-center bg-box">
                                <div class="flex-initial w-24 h-24 cover-background" style="background-image: url('{{ Img::crop(96, 96)->url($image['path']) }}')">
                                </div>
                                <div class="grow">
                                    {!! \App\Facades\Module::singular($image['type'], __('entities.' . $image['type'])) !!}
                                </div>
                                <div class="mr-2">
                                <x-button.delete-confirm size="sm" target="#delete-thumb-{{ $image['uuid'] }}" />
                                </div>
                                {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => [
                                                'campaign.default-images.delete',
                                                $campaign
                                            ],
                                            'class' => 'hidden',
                                            'id' => 'delete-thumb-' . $image['uuid']
                                        ]) !!}
                                {!! Form::hidden('entity_type', $image['type']) !!}
                                {!! Form::close() !!}
                            </div>

                        @endforeach

                    </div>
            @else
                <x-cta :campaign="$campaign">
                    <p>{{ __('campaigns/default-images.call-to-action') }}</p>
                </x-cta>
            @endif
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="new-thumbnail" :loading="true" />
@endsection
