<aside class="main-sidebar main-sidebar-placeholder absolute z-840 h-auto min-h-full flex flex-col background-cover @can('member', $campaign)main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url('{{ Img::crop(240, 208)->url($campaign->image) }}')" @endif>
    @include('layouts.sidebars._campaign')
    <section class="sidebar grow">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0 flex flex-col gap-0.5">
            @foreach ($layout as $item)
                @if (isset($item['children']))
                    <li class="sidebar-v2-section pt-4" data-section="{{ $item['id'] }}">
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
</aside>
