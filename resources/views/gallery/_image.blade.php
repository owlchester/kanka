<?php
/**
* @var \App\Models\Image $image
*/
?>

<li tabindex="0" class="block overflow-hidden rounded shadow-sm aspect-square w-[47%] xs:w-[25%] sm:w-48 cursor-pointer flex flex-col bg-box select-none hover:shadow-md focus:shadow-md  @if ($image->is_folder) items-center justify-center @endif"
    role="checkbox" aria-label="{{ $image->name }}" aria-checked="false" data-id="{{ $image->id }}"
    data-url="{{ route('images.edit', $image) }}" @if ($image->is_folder) data-folder="{{ route('campaign.gallery.index', ['folder_id' => $image->id]) }}" @endif title="{{ $image->name }}">
    @if ($image->isFolder())
        <div class="w-full flex flex-col items-center gap-2">
            <x-icon class="fa-regular fa-folder text-4xl"></x-icon>
            <div class="text-base overflow-hidden text-center px-2">

                @if ($image->visibility_id != \App\Models\Visibility::VISIBILITY_ALL)
                    {!! $image->visibilityIcon() !!}
                @endif
                {{ $image->name }}
            </div>
        </div>
    @else
        @if ($image->isFont())
            <div class="block grow w-full flex flex-col justify-center items-center gap-2">
                <x-icon class="fa-regular fa-file text-4xl"></x-icon>
            </div>
        @else
            <a class="block avatar grow relative cover-background"
                style="background-image: url('{{ $image->getFocusUrl() }}')">
            </a>
        @endif
        <div class="block px-2 py-4 h-12 truncate">
            {!! $image->visibilityIcon() !!}
            {{ $image->name }}
        </div>
    @endif
</li>
