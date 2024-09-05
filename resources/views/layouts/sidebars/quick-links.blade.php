<li class="px-2 {{ $sidebar->active('bookmarks') }} sidebar-quick-links">
    <x-sidebar.element
        :url="auth()->check() && auth()->user()->can('browse', new App\Models\Bookmark()) ? route('bookmarks.index', $campaign) : null"
        :icon="$element['custom_icon'] ?? $element['icon']"
        :text="$element['custom_label'] ?? $element['label'] ?? __($element['label_key'])"
    ></x-sidebar.element>
    <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
        @foreach ($links as $bookmark)
            @include('layouts.sidebars._quick-link', ['bookmark' => $bookmark])
        @endforeach
    </ul>
</li>
