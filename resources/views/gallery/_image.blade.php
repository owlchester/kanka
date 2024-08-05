<?php
/**
* @var \App\Models\Image $image
*/
?>

<li tabindex="0" class="overflow-hidden rounded shadow-sm aspect-square w-[25%] sm:w-48 cursor-pointer flex flex-col bg-box select-none hover:shadow-md focus:shadow-md  @if ($image->is_folder) items-center justify-center @endif"
    aria-label="{{ $image->name }}"
    data-id="{{ $image->id }}"
    data-url="{{ route('images.edit', [$campaign, $image]) }}"
    @if ($image->is_folder) data-folder="{{ route('gallery', [$campaign, 'folder_id' => $image->id]) }}" @endif
    title="{{ $image->name }}">
    @if ($image->isFolder())
        <div class="w-full flex flex-col items-center gap-2">
            <x-icon class="fa-regular fa-folder text-lg md:text-4xl"></x-icon>
            <div class="text-base overflow-hidden text-center px-2">

                @if ($image->visibility_id != \App\Enums\Visibility::All)
                    @include('icons.visibility', ['icon' => $image->visibilityIcon()])
                @endif
                {{ $image->name }}
            </div>
        </div>
    @else
        @if ($image->hasThumbnail())
            <a class="block avatar grow relative cover-background"
                style="background-image: url('{{ $image->getUrl(192, 144) }}')">
            </a>
        @else
            <div class="grow w-full flex flex-col justify-center items-center gap-2">
                <x-icon class="fa-regular fa-file text-4xl"></x-icon>
            </div>
        @endif
        <div class="block px-2 py-4 h-12 truncate">
            @include('icons.visibility', ['icon' => $image->visibilityIcon()])
            {{ $image->name }}
        </div>
    @endif
</li>
