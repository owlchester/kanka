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
        <x-campaigns.page-header
            :title="__('campaigns/recovery.title')"
            learn-more-url="features/campaigns/recovery.html"
            :lead="__('campaigns/recovery.tutorial', ['amount' => '<span class=font-extrabold>' . config('entities.hard_delete') . '</span>'])"
        />
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
