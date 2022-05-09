<?php /** @var \App\Models\Image $image */?>


@if(!empty($folder))
    @if(empty($folder->folder_id))
        <li tabindex="0" data-folder="{{ route('campaign.gallery.index') }}">
            <div class="image-preview">
                <div class="gallery-folder">
                    <span class="text">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                    {{ __('crud.actions.back') }}
                    </span>
                </div>
            </div>
        </li>
    @else
        <li tabindex="0" data-folder="{{ route('campaign.gallery.index', ['folder_id' => $folder->folder_id]) }}">
            <div class="image-preview">
                <div class="gallery-folder">
                    <span class="text">
                    <i class="fa-solid fa-arrow-left fa-2x"></i>
                    {{ $folder->imageFolder->name }}
                    </span>
                </div>
            </div>
        </li>
    @endif
@endif

@foreach ($images as $image)
    @include('gallery._image')
@endforeach

<br class="clear" />
