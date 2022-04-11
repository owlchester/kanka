<?php /** @var \App\Models\EntityFile $asset */?>
<div class="col-md-4 col-xs-6">
    <div class="entity-asset asset-file">
        <a href="{{ Storage::url($asset->path) }}" target="_blank" class="child icon" @if($asset->isImage()) style="background-image: url({{ $asset->imageUrl() }})"@endif>
            @if (!$asset->isImage())
            <i class="fa fa-file-o"></i>
            @endif
        </a>
        <div class="child text">
            {{ $asset->name }}<br />

            @if(auth()->check() && auth()->user()->can('update', $entity->child))
                <a href="#" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_files.edit', [$entity, $asset]) }}">
                    <i class="fa-solid fa-pencil"></i>
                </a>
            @endif
            @include('cruds.partials.visibility', ['model' => $asset])
        </div>
    </div>
</div>
