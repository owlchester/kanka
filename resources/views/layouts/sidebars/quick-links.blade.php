<li class="px-2 {{ $sidebar->active('menu_links') }} sidebar-quick-links">
    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('menu_links.index') }}" class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
            <i class="{{ $element['custom_icon'] ?? $element['icon'] }}"></i>
            <span>{{ $element['custom_label'] ?? $element['label'] ?? __($element['label_key']) }}</span>
        </a>
    @else
        <div class="px-2 py-1.5 flex items-center gap-2 my-0.5 rounded">
            <i class="{{ $element['custom_icon'] ?? $element['icon'] }}"></i>
            <span>{{ $element['custom_label'] ?? $element['label'] ?? __($element['label_key']) }}</span>
        </div>
    @endif
    <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
        @foreach ($links as $menuLink)
            @include('layouts.sidebars._quick-link', ['menuLink' => $menuLink])
        @endforeach
    </ul>
</li>
