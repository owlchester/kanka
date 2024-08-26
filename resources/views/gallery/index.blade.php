<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Image $image
 * @var \App\Models\Image $folder
 * @var \App\Services\Campaign\GalleryService $galleryService
 */

$breadcrumbs[] = ['url' => route('gallery', $campaign), 'label' => __('campaigns/gallery.breadcrumb')];
if ($folder) {
    if (!empty($folder->folder_id)) {
        if (!empty($folder->imageFolder->folder_id)) {
            $breadcrumbs[] = '...';
        }
        $breadcrumbs[] = ['url' => route('gallery', [$campaign, 'folder_id' => $folder->folder_id]), 'label' => e($folder->imageFolder->name)];
    }
    $breadcrumbs[] = e($folder->name);
}
?>
@extends('layouts.app', [
    'title' => __('campaigns/gallery.breadcrumb') . ' - ' . $campaign->name,
    'breadcrumbs' => $breadcrumbs,
    'bodyClass' => 'campaign-gallery',
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <div id="gallery">
        <gallery
            api="{{ route('gallery.setup', [$campaign]) }}"
        ></gallery>
    </div>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/gallery/gallery.js')
@endsection
