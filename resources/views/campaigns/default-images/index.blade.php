<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.default-images') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.default-images')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')

    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.default-images') }}
            </h3>
            <x-learn-more url="features/campaigns/default-thumbnails.html" />
            @if ($campaign->boosted())
                @can('recover', $campaign)
                <a href="{{ route('campaign.default-images.create', $campaign) }}" class="btn2 btn-primary btn-sm"
                   data-toggle="dialog-ajax" data-target="new-thumbnail"
                   data-url="{{ route('campaign.default-images.create', $campaign) }}">
                    <x-icon class="plus" />
                    {{ __('campaigns/default-images.actions.add') }}
                </a>
                @endif
            @endif
        </div>
        @if ($campaign->boosted())
            @if (empty($campaign->defaultImages()))
                <x-helper>
                    <p>{{ __('campaigns/default-images.empty') }}</p>
                </x-helper>
            @endif
            <div class="grid grid-cols-1 gap-2 xl:grid-cols-2 xl:gap-5">
                @foreach ($campaign->defaultImages() as $image)
                    @if (!\Illuminate\Support\Arr::has($entityTypes, $image['type']))
                        @continue
                    @endif
                    <div class="rounded-xl overflow-hidden flex gap-5 items-center bg-box p-2 shadow-xs hover:shadow">
                        <div class="flex-initial w-24 h-24 cover-background rounded-xl" style="background-image: url('{{ Img::crop(96, 96)->url($image['path']) }}')">
                        </div>
                        <div class="grow flex flex-col gap-1">
                            <span class="text-lg">
                                {!! $entityTypes[$image['type']]->plural() !!}
                            </span>
                            <span class="text-sm text-neutral-content">
                                {{ __('campaigns/default-images.helper') }}
                            </span>
                        </div>
                        @can('recover', $campaign)
                        <div class="mr-2">
                        <x-button.delete-confirm size="sm" target="#delete-thumb-{{ $image['uuid'] }}" />
                        </div>
                        <x-form method="DELETE" :action="['campaign.default-images.delete', $campaign]" class="hidden" id="delete-thumb-{{ $image['uuid'] }}" >
                            <input type="hidden" name="entity_type" value="{{ $entityTypes[$image['type']]->id }}" />
                        </x-form>
                        @endcan
                    </div>

                @endforeach

            </div>
        @else
            <x-premium-cta :campaign="$campaign">
                <p>{{ __('campaigns/default-images.call-to-action') }}</p>
            </x-premium-cta>
        @endif
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="new-thumbnail" :loading="true" />
@endsection
