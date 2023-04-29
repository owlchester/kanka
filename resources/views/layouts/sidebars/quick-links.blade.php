<li class="{{ $sidebar->active('menu_links') }} sidebar-quick-links">
    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('menu_links.index') }}">
            <i class="{{ $element['custom_icon'] ?? $element['icon'] }}"></i>
            {{ $element['custom_label'] ?? $element['label'] ?? __($element['label_key']) }}
        </a>
    @else
        <span>
            <i class="{{ $element['custom_icon'] ?? $element['icon'] }}"></i>
            {{ $element['custom_label'] ?? $element['label'] ?? __($element['label_key']) }}
        </span>
    @endif
    <ul class="sidebar-submenu">
        @foreach ($links as $menuLink)
            @include('layouts.sidebars._quick-link', ['menuLink' => $menuLink])
        @endforeach
    </ul>
</li>
