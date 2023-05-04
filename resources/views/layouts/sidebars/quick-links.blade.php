<li class="px-2 {{ $sidebar->active('menu_links') }} sidebar-quick-links">
    <x-sidebar.element
        :url="auth()->check() && auth()->user()->isAdmin() ? route('menu_links.index') : null"
        :icon="$element['custom_icon'] ?? $element['icon']"
        :text="$element['custom_label'] ?? $element['label'] ?? __($element['label_key'])"
    ></x-sidebar.element>
    <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
        @foreach ($links as $menuLink)
            @include('layouts.sidebars._quick-link', ['menuLink' => $menuLink])
        @endforeach
    </ul>
</li>
