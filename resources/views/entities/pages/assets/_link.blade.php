<?php /** @var \App\Models\EntityLink $asset */?>
<div class="col-md-4 col-xs-6">
    <div class="entity-asset asset-link">
        <a href="{{ route('entities.entity_links.go', [$entity, $asset]) }}" target="_blank" class="child icon">
            @if($asset->icon)
                <i class="{{ $asset->icon }}"></i>
            @else
                <i class="fa fa-map"></i>
            @endif
        </a>
        <div class="child text">
            {{ $asset->name }}<br />
            <div class="url">{{ $asset->url }}</div>

            @if(auth()->check() && auth()->user()->can('update', $entity->child))
                <a href="#" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_links.edit', [$entity, $asset]) }}">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            @endif
            @include('cruds.partials.visibility', ['model' => $asset])

        </div>
    </div>
</div>
