@php
    $canSwitchWorlds = auth()->check() && !\App\Facades\Identity::isImpersonating();
@endphp
<section class="sidebar-campaign relative h-36 flex-none overflow-hidden flex items-end">
    <div class="hidden md:flex absolute top-2 right-2 items-center gap-1 z-10">
        <button
            type="button"
            data-sidebar-action="toggle"
            data-tooltip
            data-html="true"
            data-title="{{ __('crud.keyboard-shortcut', ['code' => '<code>]</code>']) }}"
            aria-label="{{ __('header.toggle_navigation') }}"
            class="size-8 rounded-lg bg-black/35 hover:bg-black/55 text-white/90 hover:text-white backdrop-blur-sm inline-flex items-center justify-center transition-colors cursor-pointer"
        >
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="18" height="18" x="3" y="3" rx="2" />
                <path d="M9 3v18" />
                <path d="m16 15-3-3 3-3" />
            </svg>
        </button>
    </div>
    <div class="campaign-block px-4 py-4 w-full">
        <div class="campaign-head">
            <div class="flex gap-2 items-center">
                @if ($canSwitchWorlds)
                    <button
                        type="button"
                        data-sidebar-action="worlds"
                        data-tooltip
                        data-title="{{ __('entities.campaigns') }}"
                        aria-label="{{ __('entities.campaigns') }}"
                        class="group flex items-center gap-1.5 min-w-0 grow text-left cursor-pointer"
                    >
                        <span class="campaign-name truncate text-xl">
                            {!! $campaign->name !!}
                        </span>
                        <x-icon class="fa-regular fa-angle-down text-xs text-white/75 group-hover:text-white hidden md:inline-block shrink-0" />
                    </button>
                @else
                    <div class="campaign-name grow truncate text-xl">
                        {!! $campaign->name !!}
                    </div>
                @endif
                @if (!$campaign->image && auth()->check() && auth()->user()->can('update', $campaign))
                    <a href="#" class="text-white/80 hover:text-white shrink-0" data-toggle="dialog"
                       data-url="{{ route('campaign.sidebar.image', [$campaign]) }}" data-tooltip data-title="{{ __('campaigns/sidebar.tooltips.image') }}">
                        <x-icon class="fa-regular fa-image" />
                    </a>
                @endif
            </div>

            <div class="campaign-updated text-xs truncate">
                {{ __('sidebar.campaign_switcher.updated') }} {{ $campaign->updated_at->diffForHumans() }}
            </div>
        </div>
    </div>
</section>
