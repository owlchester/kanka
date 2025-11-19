@extends('layouts.app', [
    'title' => __('campaigns/recovery.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <div class="flex gap-2 items-center justify-between">
            <h3 class="">
                {{ __('campaigns/recovery.title') }}
            </h3>

            <x-learn-more url="features/campaigns/recovery.html" />
        </div>

        <p>{!! __('campaigns/recovery.tutorial', ['amount' => '<span class="font-extrabold">' . config('entities.hard_delete') . '</span>']) !!}</p>
        <div id="recovery">
            <recovery
                api="{{ route('recovery.setup', [$campaign]) }}"
            ></recovery>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    @vite('resources/js/recovery/recovery.js')
@endsection
