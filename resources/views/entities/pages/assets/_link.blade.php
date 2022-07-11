<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="">
    <div class="entity-asset asset-link">
        <a href="{{ route('entities.entity_assets.go', [$entity, $asset]) }}" target="_blank" class="child icon">
            <i class="{{ $asset->icon() }}"></i>
        </a>
        <div class="child text">
            {!! $asset->name !!}<br />
            <div class="url">{{ $asset->metadata['url'] }}</div>

            @if(auth()->check() && auth()->user()->can('update', $entity->child))
                <a href="#" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.edit', [$entity, $asset]) }}">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            @endif
            {!! $asset->visibilityIcon() !!}

        </div>
    </div>
</div>
