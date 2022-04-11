<?php /** @var \App\Models\EntityAlias $asset */?>
<div class="col-md-4 col-xs-6">
    <div class="entity-asset asset-link" data-id="{{ $asset->id }}" data-asset-type="alias">
        <span href="#" class="child icon">
            <i class="fa fa-arrow-right"></i>
        </span>
        <div class="child text">
            {{ $asset->name }}<br />

            @if(auth()->check() && auth()->user()->can('update', $entity->child))
                <a href="{{ route('entities.entity_aliases.edit', [$entity, $asset]) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_aliases.edit', [$entity, $asset]) }}">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            @endif
            {!! $asset->visibilityIcon() !!}
        </div>
    </div>
</div>
