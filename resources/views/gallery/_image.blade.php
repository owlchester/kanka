<?php
/**
* @var \App\Models\Image $image
*/
?>

<li tabindex="0" role="checkbox" aria-label="{{ $image->name }}" aria-checked="false" data-id="{{ $image->id }}"
    data-url="{{ route('images.edit', $image) }}" @if ($image->is_folder) data-folder="{{ route('campaign.gallery.index', ['folder_id' => $image->id]) }}" @endif>
    <div class="image-preview">
        @if ($image->is_folder)
            <div class="gallery-folder">
                <span class="text">
                    <i class="fa fa-folder fa-2x"></i>
                    {{ $image->name }}
                </span>
            </div>
        @else
            <img class="gallery-thumbnail" src="{{ Img::crop(100, 100)->url($image->path) }}"/>
            <span class="thumbnail-text">
                {{ $image->name }}
            </span>
        @endif
    </div>
</li>
