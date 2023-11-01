<div class="widget-body @if($widget->conf('full') === '2') p-0 @else p-4 @endif">
    @if ($widget->conf('full') === '1')
        @include('dashboard.widgets.previews._full')
    @elseif ($widget->conf('full') === '2')
        <iframe src="{{ route('entities.attributes-dashboard', [$campaign, $entity]) }}" class="entity-attributes w-full"></iframe>
    @else
        @include('dashboard.widgets.previews._preview')
    @endif
</div>
