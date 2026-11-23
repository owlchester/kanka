@php
    $isImpersonating = auth()->check() && \App\Facades\Identity::isImpersonating();
@endphp
<div class="desktop-floating-nav fixed top-3 left-3 z-850 items-center gap-1 rounded-full bg-base-100/90 backdrop-blur-md p-1 shadow-lg ring-1 ring-base-content/10 text-base-content">
    <button
        type="button"
        data-sidebar-action="toggle"
        data-tooltip
        data-html="true"
        data-title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
        aria-label="{{ __('header.toggle_navigation') }}"
        class="size-8 rounded-full inline-flex items-center justify-center hover:bg-base-200 transition-colors cursor-pointer"
    >
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect width="18" height="18" x="3" y="3" rx="2" />
            <path d="M9 3v18" />
            <path d="m14 9 3 3-3 3" />
        </svg>
    </button>

    @if (auth()->check() && !$isImpersonating)
        <button
            type="button"
            data-sidebar-action="worlds"
            data-tooltip
            data-title="{{ __('entities.campaigns') }}"
            aria-label="{{ __('entities.campaigns') }}"
            class="size-8 rounded-full inline-flex items-center justify-center hover:bg-base-200 transition-colors cursor-pointer"
        >
            @if (!empty($campaign) && $campaign->image)
                <img src="{{ Img::for($campaign->image)->crop(64, 64)->url() }}" alt="{{ $campaign->name }}" class="size-7 rounded-full object-cover" />
            @else
                <x-icon class="fa-regular fa-earth-americas text-sm" />
            @endif
        </button>
    @endif

    @if (!empty($campaign))
        <button
            type="button"
            data-sidebar-action="search"
            data-tooltip
            data-html="true"
            data-title="{{ __('crud.keyboard-shortcut', ['code' => '<code>K</code>']) }}"
            aria-label="{{ __('crud.search') }}"
            class="size-8 rounded-full inline-flex items-center justify-center hover:bg-base-200 transition-colors cursor-pointer"
        >
            <x-icon class="fa-solid fa-magnifying-glass text-sm" />
        </button>

        @if (auth()->check() && auth()->user()->can('member', $campaign) && (!isset($qq) || $qq))
            <a
                href="#"
                data-url="{{ route('entity-creator.selection', $campaign) }}"
                data-toggle="dialog"
                data-tooltip
                data-title="{{ __('header.qq.tooltip') }}"
                aria-label="{{ __('crud.create') }}"
                class="size-8 rounded-full inline-flex items-center justify-center hover:bg-primary hover:text-primary-content transition-colors"
            >
                <x-icon class="fa-regular fa-plus text-sm" />
            </a>
        @endif
    @endif

    <span class="w-px h-5 bg-base-content/15 mx-0.5" aria-hidden="true"></span>

    @auth
        @if ($isImpersonating)
            <button
                type="button"
                data-sidebar-action="profile"
                class="bg-warning hover:bg-warning/90 text-warning-content rounded-full px-2.5 h-8 text-xs font-semibold inline-flex items-center gap-1.5 cursor-pointer transition-colors"
            >
                <span class="truncate max-w-36">{{ __('campaigns.members.impersonating.acting_as_short') }}</span>
            </button>
        @else
            @php
                $avatar = auth()->user()->getAvatarUrl(36);
                $isDefaultAvatar = empty($avatar) || str_contains($avatar, '/images/defaults/user.svg');
                $showInitials = !$isDefaultAvatar && str_starts_with($avatar, '/images/');
            @endphp
            <button
                type="button"
                data-sidebar-action="profile"
                data-tooltip
                data-title="{{ __('settings.menu.account') }}"
                aria-label="{{ __('settings.menu.account') }}"
                class="size-8 rounded-full inline-flex items-center justify-center hover:bg-base-200 transition-colors cursor-pointer"
            >
                <div class="indicator relative inline-flex">
                    <span
                        data-nav-alert-dot
                        class="notification-badge absolute -right-0.5 -bottom-0.5 size-2 rounded-full z-10 @if (!auth()->user()->hasUnread()) hidden @endif"
                    ></span>
                    @if ($showInitials)
                        <div class="size-7 rounded-full bg-neutral text-neutral-content flex items-center justify-center text-[10px] font-bold uppercase">
                            {{ auth()->user()->initials() }}
                        </div>
                    @elseif ($isDefaultAvatar)
                        <x-icon class="fa-regular fa-circle-user text-lg text-base-content/80" />
                    @else
                        <div class="size-7 rounded-full cover-background" style="background-image: url('{{ $avatar }}')"></div>
                    @endif
                </div>
            </button>
        @endif
    @else
        <a href="{{ route('login') }}" class="px-2.5 h-8 rounded-full text-xs font-medium inline-flex items-center hover:bg-base-200 text-link">
            {{ __('front.menu.login') }}
        </a>
    @endauth
</div>
