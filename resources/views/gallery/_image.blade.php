<?php
/**
* @var \App\Models\Image $image
*/
?>

<li tabindex="0" class="w-40 p-2 rounded shadow-xs cursor-pointer flex flex-col items-center justify-center text-center select-none gap-2 hover:shadow-md focus:shadow-md bg-box"
    role="checkbox" aria-label="{{ $image->name }}" aria-checked="false" data-id="{{ $image->id }}"
    data-url="{{ route('images.edit', $image) }}" @if ($image->is_folder) data-folder="{{ route('campaign.gallery.index', ['folder_id' => $image->id]) }}" @endif title="{{ $image->name }}">
    @if ($image->is_folder)
        <div class="w-full flex flex-col items-center gap-2">
            <i class="fa-regular fa-folder text-4xl" aria-hidden="true"></i>
            <div class="text-base overflow-hidden">

                @if ($image->visibility_id != \App\Models\Visibility::VISIBILITY_ALL)
                    {!! $image->visibilityIcon() !!}
                @endif
                {{ $image->name }}
            </div>
        </div>
    @else
        <div class="block rounded cover-background image-preview w-full aspect-square"
             style="background-image: url('{{ Img::crop(144, 144)->url($image->path) }}')">
        </div>
        <div class="w-full flex items-center gap-2">
            {!! $image->visibilityIcon() !!}
            <div class="truncate">{{ $image->name }}</div>
        </div>
    @endif
</li>
