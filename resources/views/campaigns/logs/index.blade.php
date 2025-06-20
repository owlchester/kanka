@php
/** @var \App\Models\Campaign $campaign */
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.logs') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.logs')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('ads.top')
    @include('partials.errors')

    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.logs') }}
            </h3>
            <x-learn-more url="features/campaigns/logs" />
        </div>

        @includeWhen(!$logs->isEmpty(), 'campaigns.logs._list')
        @if($logs->isEmpty())
            <div class="flex flex-col gap-2 justify-center items-center">
                <div class="text-xl">
                    {{ __('campaigns/logs.helpers.title') }}
                </div>
                <div class="text-sm text-neutral-content text-center max-w-md flex flex-col gap-4">
                    <p>{!! __('campaigns/logs.helpers.nothing', ['amount' => '<code>' . $cutoff . '</code>']) !!}</p>
                </div>
            </div>
        @endif


        @if (!$campaign->premium())
            <x-premium-cta :campaign="$campaign" premium>
                <p>
                    {!! __('campaigns/logs.pitch', ['amount' => '<code>' . config('limits.campaigns.logs.premium') . '</code>']) !!}
                </p>
            </x-premium-cta>
        @endif
    </div>
@endsection

