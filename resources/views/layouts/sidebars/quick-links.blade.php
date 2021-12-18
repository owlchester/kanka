<li class="{{ $sidebar->active('menu_links') }} section sidebar-section sidebar-quick-links">
    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('menu_links.index') }}">
            <i class="fa fa-star"></i>
            <span>{{ __('entities.menu_links') }}</span>
        </a>
    @else
    <div class="sidebar-text">
        <i class="fa fa-star"></i>
        <span>{{ __('entities.menu_links') }}</span>

        @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('menu_links.index') }}" class="pull-right sidebar-icon-link">
                <i class="fas fa-cog"></i>
            </a>
        @endif
    </div>
    @endif
</li>
@foreach ($currentCampaign->menuLinks()->with(['target'])->ordered()->get() as $menuLink)
    <?php /** @var \App\Models\MenuLink $menuLink */ ?>
    @if ($menuLink->dashboard && $currentCampaign->boosted() && $menuLink->isValidDashboard())
        <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
            <a href="{{ $menuLink->getRoute() }}">
                <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
            </a>
        </li>
    @elseif ($menuLink->target)
        <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
            <a href="{{ $menuLink->getRoute() }}">
                <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
            </a>
        </li>
    @elseif ($menuLink->type)
        <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
            <a href="{{ $menuLink->getRoute() }}">
                <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
            </a>
        </li>
    @elseif ($menuLink->isRandom())
        <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
            <a href="{{ route('menu_links.random', $menuLink) }}">
                <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
            </a>
        </li>
    @endif
@endforeach
