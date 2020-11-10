<?php /** @var \App\Models\Image $image */?>

@foreach ($images as $image)
    @include('gallery._image')
@endforeach

<br class="clear" />
