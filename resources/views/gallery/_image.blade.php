<?php /**
 * @var \App\Models\Image $image
 */?>
<li tabindex="0" role="checkbox" aria-label="{{ $image->name }}" aria-checked="false" data-id="{{ $image->id }}" data-url="{{ route('images.edit', $image) }}">
    <div class="image-preview">
        <div class="gallery-thumbnail cover-background" style="background-image: url({{ Img::crop(100, 100)->url($image->path) }})">
        </div>
    </div>
</li>
