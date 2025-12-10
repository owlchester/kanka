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
        back="{{ route('relations.index', [$campaign]) }}"
        action-back="{{ __('connections/web.actions.back') }}"
        :premium="@js($campaign->boosted())"
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
