<x-dialog.header>
 {!! $name !!}
</x-dialog.header>
<article class="max-w-xl container p-4 md:px-6">
    @if ($marker->hasEntry())
        <div class="marker-entry entity-content">
            {!! \App\Facades\Mentions::mapAny($marker) !!}
        </div>
    @endif
    @if ($marker->entity && $marker->entity->hasEntry())
        <div class="marker-entry entity-content">
            {!! $marker->entity->parsedEntry() !!}
        </div>
    @endif
    <x-dialog.footer :dialog="true">
        @can('update', $marker->map->entity)
            <a href="{{ route('maps.map_markers.edit', [$campaign, $marker->map, $marker, 'from' => 'explore']) }}" class="btn2 btn-ghost btn-sm join-item">
                <x-icon class="fa-regular fa-map-pin" />
                {{ __('maps/markers.actions.update') }}
            </a>
        @endcan
    </x-dialog.footer>
</article>
