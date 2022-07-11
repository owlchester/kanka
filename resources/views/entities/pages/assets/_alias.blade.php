<?php /** @var \App\Models\EntityAsset $asset */?>
<div class="">
    <div class="entity-asset asset-link" data-id="{{ $asset->id }}" data-asset-type="alias">
        <span href="#" class="child icon">
            <i class="fa-solid fa-arrow-right"></i>
        </span>
        <div class="child text">
            {{ $asset->name }}<br />

            @if(auth()->check() && auth()->user()->can('update', $entity->child))
                <a href="{{ route('entities.entity_assets.edit', [$entity, $asset]) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_assets.edit', [$entity, $asset]) }}">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            @endif
            {!! $asset->visibilityIcon() !!}
        </div>
    </div>
</div>
