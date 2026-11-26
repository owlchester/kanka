<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="entity-assets">
    @if ($assets->isEmpty())
        @include('entities.pages.assets._empty-state')
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 entity-assets-row">
            @foreach ($assets as $asset)
                @if ($asset->hiddenImage()) @continue @endif
                @includeWhen($asset->isFile(), 'entities.pages.assets._file')
                @includeWhen($asset->isLink(), 'entities.pages.assets._link')
            @endforeach
        </div>
    @endif
</div>


@section('modals')
    @parent
    <x-dialog id="asset-update-dialog" :loading="true" />
@endsection
