<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="entity-assets">
    <div class="flex flex-col lg:flex-row flex-wrap gap-4 max-w-7xl entity-assets-row">
        @forelse ($assets as $asset)
            @if ($asset->hiddenImage()) @continue @endif
            @includeWhen($asset->isFile(), 'entities.pages.assets._file')
            @includeWhen($asset->isLink(), 'entities.pages.assets._link')
        @empty
        @endforelse
    </div>
</div>


@section('modals')
    @parent
    <x-dialog id="asset-update-dialog" :loading="true" />
@endsection
