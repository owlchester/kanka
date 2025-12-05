<?php /** @var \App\Models\Image $image */?>


@if(!empty($folder))
    <li tabindex="0" data-folder="{{ empty($folder->folder_id) ? route('gallery', $campaign) : route('gallery', [$campaign, 'folder_id' => $folder->folder_id]) }}" class="overflow-hidden rounded shadow-sm aspect-square w-[25%] sm:w-48 cursor-pointer flex flex-col bg-box select-none hover:shadow-md focus:shadow-md items-center justify-center">
        <div class="w-full flex flex-col items-center gap-2 text-lg">
            <x-icon class="fa-regular fa-arrow-left" />
            <div class="text-base overflow-hidden">
                @if (empty($folder->folder_id))
                    {{ __('crud.actions.back') }}
                @else
                    {{ $folder->imageFolder->name }}
                @endif
            </div>
        </div>
    </li>
@endif

@foreach ($images as $image)
    @include('gallery._image')
@endforeach

<br class="clear-both" />
