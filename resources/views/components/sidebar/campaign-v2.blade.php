<aside class="main-sidebar main-sidebar-placeholder z-840 flex flex-col transition-all duration-150 @can('member', $campaign)main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url('{{ Img::for($campaign->image)->crop(240, 208)->url() }}')" @endif>
    @include('layouts.sidebars._campaign')
    @include('layouts.sidebars._actions')
    <section class="sidebar grow">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0 flex flex-col gap-0.5">
            @foreach ($layout as $item)
                @if (isset($item['children']))
                    <li class="sidebar-v2-section pt-3 first:pt-0" data-section="{{ $item['id'] }}">
                        <x-sidebar.section :text="$item['label']" :url="$item['url']" />
                        <ul class="sidebar-submenu list-none p-0 m-0 flex flex-col gap-0.5">
                            @foreach ($item['children'] as $entry)
                                @include('layouts.sidebars.v2-item')
                            @endforeach
                        </ul>
                    </li>
                @else
                    @include('layouts.sidebars.v2-item', ['entry' => $item])
                @endif
            @endforeach
        </ul>
    </section>
    @include('layouts.sidebars._user')
</aside>
