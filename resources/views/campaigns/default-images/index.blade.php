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
        <div class="grow max-w-7xl">
            <div class="flex gap-2 mb-5 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.default-images') }}
                </h3>
                @if ($campaign->boosted())
                    <button class="btn btn-default btn-sm" data-toggle="dialog"
                            data-target="default-images-help">
                        <x-icon class="question"></x-icon>
                        {{ __('campaigns.members.actions.help') }}
                    </button>

                    <a href="{{ route('campaign.default-images.create') }}" class="btn btn-primary btn-sm"
                       data-toggle="ajax-modal" data-target="#entity-modal"
                       data-url="{{ route('campaign.default-images.create') }}">
                        <x-icon class="plus"></x-icon>
                        {{ __('campaigns/default-images.actions.add') }}
                    </a>
                @endif
            </div>
            @if ($campaign->boosted())
                <x-box :padding="false">
                    @if (empty($campaign->defaultImages()))
                        <div class="p-4">
                            <a href="{{ route('campaign.default-images.create') }}" class="btn btn-primary"
                               data-toggle="ajax-modal" data-target="#entity-modal"
                               data-url="{{ route('campaign.default-images.create') }}">
                                <x-icon class="plus"></x-icon>
                                {{ __('campaigns/default-images.actions.add') }}
                            </a>
                        </div>
                    @endif
                    <table class="table table-borderless">
                        <tbody>
                        @foreach ($campaign->defaultImages() as $image)
                            <tr>
                                <td class="w-16">
                                    <div class="entity-image cover-background" style="background-image: url({{ Img::crop(40, 40)->url($image['path']) }})"></div>
                                </td>
                                <td>
                                    {!! \App\Facades\Module::singular($image['type'], __('entities.' . $image['type'])) !!}
                                </td>
                                <td class="text-right">
                                    <button class="btn btn-sm btn-danger delete-confirm" data-toggle="modal" data-name="{{ __('entities.' . $image['type']) }}"
                                            data-target="#delete-confirm" data-delete-target="delete-form-{{ $image['uuid'] }}"
                                            title="{{ __('crud.remove') }}">
                                        <x-icon class="trash"></x-icon>
                                        <span>{{ __('crud.remove') }}</span>
                                    </button>
                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => [
                                            'campaign.default-images.delete',
                                        ],
                                        'style' => 'display:inline',
                                        'id' => 'delete-form-' . $image['uuid']
                                    ]) !!}
                                    {!! Form::hidden('entity_type', $image['type']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </x-box>
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
