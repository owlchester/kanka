<div class="entity-assets">
    <div class="grid grid-cols-3 gap-2 entity-assets-row">
        @forelse ($assets as $asset)
            @includeWhen($asset->isFile(), 'entities.pages.assets._file')
            @includeWhen($asset->isLink(), 'entities.pages.assets._link')
            @includeWhen($asset->isAlias(), 'entities.pages.assets._alias')
        @empty
            @can('update', $entity->child)
                <a href="#" class="btn2 btn-accent btn-outline" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_ALIAS]) }}">
                    <x-icon class="plus"></x-icon> {{ __('entities/assets.actions.alias') }}
                </a>
                <a href="#" class="btn2 btn-accent btn-outline" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_FILE]) }}">
                    <x-icon class="plus"></x-icon> {{ __('entities/assets.actions.file') }}
                </a>
                <a href="#" class="btn2 btn-accent btn-outline" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.create', [$entity, 'type' => \App\Models\EntityAsset::TYPE_LINK]) }}">
                    <x-icon class="plus"></x-icon> {{ __('entities/assets.actions.link') }}
                </a>
            @endcan
        @endforelse
    </div>
</div>

