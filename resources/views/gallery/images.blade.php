<?php /** @var \App\Models\Image $image */?>


@if(!empty($folder))
    <li tabindex="0" data-folder="{{ empty($folder->folder_id) ? route('campaign.gallery.index') : route('campaign.gallery.index', ['folder_id' => $folder->folder_id]) }}" class="pull-left h-36 w-32 p-2 m-2 rounded drop-shadow cursor-pointer flex flex-col items-center justify-center text-center select-none">
        <i class="fa-solid fa-arrow-left fa-2x mb-3" aria-hidden="true"></i>
        <div class="w-full truncate">
            @if (empty($folder->folder_id))
                {{ __('crud.actions.back') }}
            @else
                {{ $folder->imageFolder->name }}
            @endif
        </div>
    </li>
@endif

@foreach ($images as $image)
    @include('gallery._image')
@endforeach

<br class="clear" />
