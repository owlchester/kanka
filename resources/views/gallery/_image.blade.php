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
                    @if ($image->visibility_id == \App\Models\Visibility::VISIBILITY_ALL)
                    <i class="fa fa-folder fa-2x"></i>
                    @else
                        {!! $image->visibilityIcon('fa-2x') !!}
                    @endif
                    {{ $image->name }}
                </span>
            </div>
        @else
            <div class="gallery-thumbnail cover-background"
                style="background-image: url('{{ Img::crop(100, 100)->url($image->path) }}')">
            </div>
            <span class="thumbnail-text">
                {!! $image->visibilityIcon() !!} {{ $image->name }}
            </span>
        @endif
    </div>
</li>
