@php
    $isImpersonating = auth()->check() && \App\Facades\Identity::isImpersonating();
@endphp
<div class="hidden md:block flex-none">
    @auth
        @if ($isImpersonating)
            <button
                type="button"
                data-sidebar-action="profile"
                class="w-full rounded-[var(--sidebar-radius)] bg-warning hover:bg-warning/90 text-warning-content px-3 py-2.5 flex items-center justify-between gap-2 text-sm font-semibold transition-colors cursor-pointer"
            >
                <span class="truncate">{{ __('campaigns.members.impersonating.acting_as', ['name' => auth()->user()->name]) }}</span>
                <x-icon class="fa-regular fa-angle-right shrink-0" />
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
                aria-label="{{ __('settings.menu.account') }}"
                class="w-full rounded-[var(--sidebar-radius)] bg-base-100 hover:bg-base-200 text-base-content px-2.5 py-2 flex items-center gap-2.5 transition-colors cursor-pointer text-left"
            >
                <div class="indicator relative inline-flex shrink-0">
                    <span
                        data-nav-alert-dot
                        class="notification-badge absolute -right-1 -bottom-1 size-2.5 rounded-full z-10 @if (!auth()->user()->hasUnread()) hidden @endif"
                    ></span>
                    @if ($showInitials)
                        <div class="size-8 rounded-lg bg-neutral text-neutral-content flex items-center justify-center text-xs font-bold uppercase">
                            {{ auth()->user()->initials() }}
                        </div>
                    @elseif ($isDefaultAvatar)
                        <div class="size-8 rounded-lg flex items-center justify-center">
                            <x-icon class="fa-regular fa-circle-user text-2xl text-base-content/80" />
                        </div>
                    @else
                        <div class="size-8 rounded-lg cover-background" style="background-image: url('{{ $avatar }}')"></div>
                    @endif
                </div>
                <span class="truncate text-sm font-medium grow">{{ auth()->user()->name }}</span>
                <x-icon class="fa-regular fa-angle-right text-xs text-base-content/50 shrink-0" />
            </button>
        @endif
    @else
        <div class="rounded-[var(--sidebar-radius)] bg-base-100 p-2 flex items-center justify-between gap-2">
            <a href="{{ route('login') }}" class="text-link text-sm px-2 py-1 truncate">
                {{ __('front.menu.login') }}
            </a>
            @if (config('auth.register_enabled'))
                <a href="{{ route('register') }}" class="btn2 btn-primary btn-xs shrink-0">
                    {{ __('front.menu.register') }}
                </a>
            @endif
        </div>
    @endauth
</div>
