@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.sidebar') . ' - ' . $campaign->name,
    'breadcrumbs' => [__('campaigns.show.tabs.sidebar')],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => false,
])

@section('content')
    <div class="max-w-7xl mx-auto w-full flex flex-col gap-5">
        @include('partials.errors')

        <x-campaigns.page-header :title="__('campaigns.show.tabs.sidebar')" :lead="__('campaigns/sidebar-v2.lead')">
            @if ($campaign->boosted())
                <x-slot name="actions">
                    <a href="{{ route('campaign_roles.index', $campaign) }}" class="btn2 btn-sm btn-ghost">
                        <x-icon class="fa-regular fa-users-gear" />
                        {{ __('campaigns/sidebar-v2.manage_roles') }}
                    </a>
                    @if (app()->isLocal())
                        <button type="button" class="btn2 btn-sm btn-outline" data-toggle="dialog" data-target="sidebar-v2-legacy-confirm">
                            {{ __('campaigns/sidebar-v2.legacy') }}
                        </button>
                    @endif
                </x-slot>
            @endif
        </x-campaigns.page-header>

        @if (!$campaign->boosted())
            <x-premium-cta-alert :campaign="$campaign" source="sidebar">
                <x-slot name="title">{{ __('campaigns/sidebar.cta.title') }}</x-slot>
                <x-slot name="lead">{{ __('campaigns/sidebar.cta.lead') }}</x-slot>
            </x-premium-cta-alert>
        @else
            <div class="flex flex-col gap-3">
                <div class="flex flex-wrap items-center gap-2" role="navigation" aria-label="{{ __('campaigns/sidebar-v2.layout') }}">
                    @php
                        $defaultActive = $target === 'default';
                        $defaultCustom = in_array('default', $customTargets, true);
                    @endphp
                    <a
                        href="{{ route('campaign-sidebar', $campaign) }}"
                        data-sidebar-role-tab="default"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $defaultActive ? 'bg-primary text-primary-content shadow-xs' : 'bg-base-100 hover:bg-base-200 text-base-content' }}"
                    >
                        <i class="fa-duotone fa-sliders" aria-hidden="true"></i>
                        <span>{{ __('campaigns/sidebar-v2.default') }}</span>
                        <span
                            data-custom-badge
                            class="text-[11px] px-1.5 py-0.5 rounded-full font-semibold {{ $defaultActive ? 'bg-primary-content/20 text-primary-content' : 'bg-base-200 text-neutral-content' }} {{ $defaultCustom ? '' : 'hidden' }}"
                        >{{ __('campaigns/sidebar-v2.custom_badge') }}</span>
                    </a>

                    @foreach ($roles as $role)
                        @php
                            $roleKey = (string) $role->id;
                            $isActive = $target === $roleKey;
                            $isCustom = in_array($roleKey, $customTargets, true);
                            $roleIcon = $role->isPublic()
                                ? 'fa-duotone fa-globe'
                                : ($role->isAdmin() ? 'fa-duotone fa-shield-halved' : 'fa-duotone fa-users');
                        @endphp
                        <a
                            href="{{ route('campaign-sidebar', [$campaign, 'role' => $role->id]) }}"
                            data-sidebar-role-tab="{{ $roleKey }}"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $isActive ? 'bg-primary text-primary-content shadow-xs' : 'bg-base-100 hover:bg-base-200 text-base-content' }}"
                            @if ($role->isPublic()) title="{{ __('campaigns/sidebar-v2.guest_role') }}" @elseif ($role->isAdmin()) title="{{ __('campaigns/sidebar-v2.admin_role') }}" @endif
                        >
                            <i class="{{ $roleIcon }}" aria-hidden="true"></i>
                            <span>{{ $role->name }}</span>
                            <span
                                data-custom-badge
                                class="text-[11px] px-1.5 py-0.5 rounded-full font-semibold {{ $isActive ? 'bg-primary-content/20 text-primary-content' : 'bg-base-200 text-neutral-content' }} {{ $isCustom ? '' : 'hidden' }}"
                            >{{ __('campaigns/sidebar-v2.custom_badge') }}</span>
                        </a>
                    @endforeach
                </div>

                <p class="text-neutral-content text-sm mb-0">{{ __('campaigns/sidebar-v2.roles') }}</p>

                @if ($selectedRole && !$hasCustomLayout)
                    <div data-inheriting-banner class="bg-base-100 rounded-lg px-4 py-3 text-sm flex items-center gap-3">
                        <i class="fa-regular fa-circle-info text-info shrink-0" aria-hidden="true"></i>
                        <span>{{ __('campaigns/sidebar-v2.inheriting_banner', ['role' => $selectedRole->name]) }}</span>
                    </div>
                @endif

                @if (collect($catalog)->contains(fn ($entry) => ! empty($entry['duplicates_category'])))
                    <div data-duplicate-bookmarks-banner class="bg-base-100 rounded-lg px-4 py-3 text-sm flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <i class="fa-regular fa-circle-info text-warning shrink-0" aria-hidden="true"></i>
                            <span>{{ __('campaigns/sidebar-v2.duplicate_bookmarks_banner') }}</span>
                        </div>
                        <a href="{{ route('bookmarks.index', $campaign) }}" class="btn2 btn-xs btn-ghost shrink-0">
                            <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                            {{ __('campaigns/sidebar-v2.manage_bookmarks') }}
                        </a>
                    </div>
                @endif
            </div>

            <div id="sidebar-v2-editor" data-config="{{ json_encode([
                'layout' => $layout,
                'standard' => $standard,
                'defaultLayout' => $default,
                'catalog' => $catalog,
                'url' => route('campaign-sidebar-v2-save', $campaign),
                'bookmarksUrl' => route('bookmarks.index', $campaign),
                'target' => $target,
                'targetLabel' => $selectedRole ? $selectedRole->name : __('campaigns/sidebar-v2.default'),
                'hasCustomLayout' => $hasCustomLayout,
                'copySources' => $copySources,
                'inaccessible' => $inaccessible,
                'revision' => $revision,
                'resetDialogId' => 'sidebar-v2-reset-confirm',
                'resetLabel' => __('campaigns/sidebar-v2.' . ($target === 'default' ? 'reset_default' : 'reset_role')),
                'i18n' => __('campaigns/sidebar-v2.editor'),
            ]) }}"></div>
            <noscript>{{ __('campaigns/sidebar-v2.javascript') }}</noscript>
        @endif
    </div>
@endsection

@if ($campaign->boosted())
    @section('modals')
        <x-dialog id="sidebar-v2-reset-confirm" :title="__('campaigns/sidebar-v2.reset_title')">
            <x-form :action="['campaign-sidebar-v2-save', $campaign]" class="flex flex-col gap-4">
                <input type="hidden" name="action" value="reset" />
                <input type="hidden" name="target" value="{{ $target }}" />
                <input type="hidden" name="revision" value="{{ $revision }}" data-sidebar-revision-input />
                <p class="text-sm mb-0">{{ __('campaigns/sidebar-v2.confirm.reset') }}</p>
                <p class="text-neutral-content text-sm mb-0">{{ __('campaigns/sidebar-v2.' . ($target === 'default' ? 'reset_default_help' : 'reset_role_help')) }}</p>
                <div class="grid grid-cols-2 gap-2 w-full">
                    <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                        {{ __('crud.cancel') }}
                    </x-buttons.confirm>
                    <button type="submit" class="btn2 btn-outline btn-error w-full">
                        {{ __('campaigns/sidebar-v2.' . ($target === 'default' ? 'reset_default' : 'reset_role')) }}
                    </button>
                </div>
            </x-form>
        </x-dialog>

        @if (app()->isLocal())
            <x-dialog id="sidebar-v2-legacy-confirm" :title="__('campaigns/sidebar-v2.legacy_title')">
                <x-form :action="['campaign-sidebar-v2-save', $campaign]" class="flex flex-col gap-4">
                    <input type="hidden" name="action" value="legacy" />
                    <input type="hidden" name="target" value="{{ $target }}" />
                    <input type="hidden" name="revision" value="{{ $revision }}" data-sidebar-revision-input />
                    <p class="text-sm mb-0">{{ __('campaigns/sidebar-v2.confirm.legacy') }}</p>
                    <div class="grid grid-cols-2 gap-2 w-full">
                        <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                            {{ __('crud.cancel') }}
                        </x-buttons.confirm>
                        <button type="submit" class="btn2 btn-outline btn-error w-full">
                            {{ __('campaigns/sidebar-v2.legacy') }}
                        </button>
                    </div>
                </x-form>
            </x-dialog>
        @endif
    @endsection
@endif
