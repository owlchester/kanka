<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.default-images') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
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
        <div class="grow max-w-4xl">
            <div class="flex gap-2 mb-5 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.default-images') }}
                </h3>
                @if ($campaign->boosted())
                    <button class="btn2 btn-sm" data-toggle="dialog"
                            data-target="default-images-help">
                        <x-icon class="question"></x-icon>
                        {{ __('campaigns.members.actions.help') }}
                    </button>

                    <a href="{{ route('campaign.default-images.create') }}" class="btn2 btn-primary btn-sm"
                       data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route('campaign.default-images.create') }}">
                        <x-icon class="plus"></x-icon>
                        {{ __('campaigns/default-images.actions.add') }}
                    </a>
                @endif
            </div>
            @if ($campaign->boosted())
                    @if (empty($campaign->defaultImages()))
                        <x-box>
                            <a href="{{ route('campaign.default-images.create') }}" class="btn2 btn-primary"
                               data-toggle="ajax-modal" data-target="#entity-modal"
                               data-url="{{ route('campaign.default-images.create') }}">
                                <x-icon class="plus"></x-icon>
                                {{ __('campaigns/default-images.actions.add') }}
                            </a>
                        </x-box>
                    @endif
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-5">

                        @foreach ($campaign->defaultImages() as $image)
                            <div class="rounded overflow-hidden border flex gap-2 items-center bg-box">
                                <div class="w-24 h-24 cover-background" style="background-image: url('{{ Img::crop(96, 96)->url($image['path']) }}')">
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
    <x-dialog id="default-images-help" :title="__('campaigns.show.tabs.default-images')">
        <p>{{ __('campaigns/default-images.helper') }}</p>
    </x-dialog>
@endsection
