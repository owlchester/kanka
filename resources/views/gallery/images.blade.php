<?php /** @var \App\Models\Image $image */?>


@if(!empty($folder))
    <li tabindex="0" data-folder="{{ empty($folder->folder_id) ? route('campaign.gallery.index') : route('campaign.gallery.index', ['folder_id' => $folder->folder_id]) }}" class="w-40 p-2 rounded shadow-xs bg-box hover:shadow-md cursor-pointer flex flex-col items-center justify-center text-center select-none gap-2">
        <div class="w-full flex flex-col items-center gap-2 text-4xl">
            <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
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
