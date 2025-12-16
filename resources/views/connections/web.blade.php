<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.rich', [
    'title' => __('connections/web.title') . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
    'pageClass' => 'connections-web-page'
])

@section('content')
<div id="web">
    <connections-web
        api="{{ route('connections.web.api', [$campaign]) }}"
        :premium="@js($campaign->boosted())"
        :creator="{{ auth()->check() && !empty($campaign) && auth()->user()->can('member', $campaign) ? 1 : 0 }}"
    >
    </connections-web>
</div>

@endsection


@section('scripts')
    @vite('resources/js/connections/web.js')
@endsection

@section('modals')
    <x-dialog id="web-premium" :title="__('connections/web.cta.title', ['amount' => config('limits.campaigns.web')])">
        @include('connections.web-premium')
    </x-dialog>
@endsection
