<div class="entity-assets">
    <div class="grid grid-cols-3 gap-2 entity-assets-row">
        @forelse ($assets as $asset)
            @if ($asset->hiddenImage()) @continue @endif
            @includeWhen($asset->isFile(), 'entities.pages.assets._file')
            @includeWhen($asset->isLink(), 'entities.pages.assets._link')
            @includeWhen($asset->isAlias(), 'entities.pages.assets._alias')
        @empty
        @endforelse
    </div>
</div>


@section('modals')
    @parent
    <x-dialog id="asset-update-dialog" :loading="true" />
@endsection
