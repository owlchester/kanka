<li class="{{ $sidebar->active('menu_links') }} section sidebar-section sidebar-quick-links">
    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('menu_links.index') }}">
            <i class="fa fa-star"></i>
            {{ __('entities.menu_links') }}
        </a>
    @else
        <span>
            <i class="fa fa-star"></i>
            {{ __('entities.menu_links') }}
        </span>
    @endif

        <ul class="sidebar-submenu">
            @foreach ($currentCampaign->menuLinks()->with(['target'])->ordered()->get() as $menuLink)
                <?php /** @var \App\Models\MenuLink $menuLink */ ?>
                @if ($menuLink->dashboard && $currentCampaign->boosted() && $menuLink->isValidDashboard())
                    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                        <a href="{{ $menuLink->getRoute() }}">
                            <i class="{{ $menuLink->icon() }}"></i>
                            {{ $menuLink->name }}
                        </a>
                    </li>
                @elseif ($menuLink->target)
                    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                        <a href="{{ $menuLink->getRoute() }}">
                            <i class="{{ $menuLink->icon() }}"></i>
                            {{ $menuLink->name }}
                        </a>
                    </li>
                @elseif ($menuLink->type)
                    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                        <a href="{{ $menuLink->getRoute() }}">
                            <i class="{{ $menuLink->icon() }}"></i>
                            {{ $menuLink->name }}
                        </a>
                    </li>
                @elseif ($menuLink->isRandom())
                    <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                        <a href="{{ route('menu_links.random', $menuLink) }}">
                            <i class="{{ $menuLink->icon() }}"></i>
                            {{ $menuLink->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
</li>
