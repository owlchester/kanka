@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.sidebar') . ' - ' . $campaign->name,
    'breadcrumbs' => [__('campaigns.show.tabs.sidebar')],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex flex-col gap-5">
        @include('partials.errors')
        <x-campaigns.page-header :title="__('campaigns.show.tabs.sidebar')" :lead="__('campaigns/sidebar-v2.lead')" />
        @if (!$campaign->boosted())
            <x-premium-cta-alert :campaign="$campaign" source="sidebar">
                <x-slot name="title">{{ __('campaigns/sidebar.cta.title') }}</x-slot>
                <x-slot name="lead">{{ __('campaigns/sidebar.cta.lead') }}</x-slot>
            </x-premium-cta-alert>
        @else
            <label class="flex flex-col gap-2">
                <span>{{ __('campaigns/sidebar-v2.layout') }}</span>
                <select class="submenu-switcher">
                    <option data-route="{{ route('campaign-sidebar', $campaign) }}" @selected($target === 'default')>{{ __('campaigns/sidebar-v2.default') }}</option>
                    @foreach ($roles as $role)
                        <option data-route="{{ route('campaign-sidebar', [$campaign, 'role' => $role->id]) }}" @selected($target === (string) $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
            </label>
            <p class="text-neutral-content">{{ __('campaigns/sidebar-v2.roles') }}</p>
            <div id="sidebar-v2-editor" data-config="{{ json_encode([
                'layout' => $layout,
                'standard' => $standard,
                'defaultLayout' => $default,
                'catalog' => $catalog,
                'url' => route('campaign-sidebar-v2-save', $campaign),
                'target' => $target,
                'revision' => $revision,
                'i18n' => __('campaigns/sidebar-v2.editor'),
            ]) }}"></div>
            <noscript>{{ __('campaigns/sidebar-v2.javascript') }}</noscript>
            <div class="flex flex-wrap gap-3">
                @foreach (app()->isLocal() ? ['reset', 'legacy'] : ['reset'] as $action)
                    <x-form :action="['campaign-sidebar-v2-save', $campaign]">
                        <input type="hidden" name="action" value="{{ $action }}" />
                        <input type="hidden" name="target" value="{{ $target }}" />
                        <input type="hidden" name="revision" value="{{ $revision }}" />
                        <button type="submit" class="btn2 btn-outline" data-sidebar-confirm="{{ __('campaigns/sidebar-v2.confirm.' . $action) }}">{{ __('campaigns/sidebar-v2.' . ($action === 'reset' ? ($target === 'default' ? 'reset_default' : 'reset_role') : $action)) }}</button>
                        @if ($action === 'reset')
                            <p class="text-neutral-content text-sm mt-2">{{ __('campaigns/sidebar-v2.' . ($target === 'default' ? 'reset_default_help' : 'reset_role_help')) }}</p>
                        @endif
                    </x-form>
                @endforeach
            </div>
        @endif
    </div>
@endsection
