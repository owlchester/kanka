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
    <x-grid type="1/1">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <x-icon class="fa-solid fa-cloud" />
                <div class="grow text-lg">Storage</div>
                <div class="">
                    <span id="storage-used">{{ $galleryService->human($galleryService->usedSpace()) }}</span> of
                    <span id="storage-total">{{ $galleryService->human($galleryService->totalSpace()) }}</span>
                </div>
                @if (!$campaign->boosted())
                    <a href="{{ \App\Facades\Domain::toFront('pricing') }}" class="btn2 btn-sm">
                        Upgrade
                    </a>
                @endif
            </div>
            <div class="bg-base-300 w-full h-2 overflow-hidden rounded transition-all duration-300">
                <div class="{{ $galleryService->usedBarClasses() }}" style="width: {{ $galleryService->usedQuota() }}%" id="storage-progress" data-title="{{ $galleryService->usedQuota() }}%" data-toggle="tooltip"></div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <div class="grow">
                @can('galleryUpload', $campaign)
                <button class="btn2 btn-sm" data-toggle="dialog" data-target="new-folder" data-url="{{ route('campaign.gallery.folders.create', [$campaign, 'folder' => $folder ?? null]) }}">
                    <x-icon class="fa-solid fa-folder"></x-icon> {{ __('campaigns/gallery.uploader.new_folder') }}
                </button>
                @endauth

                @can('galleryManage', $campaign)
                @if(!empty($folder))
                    <button class="btn2 btn-sm" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('images.edit', [$campaign, $folder]) }}">
                        <x-icon class="pencil"></x-icon> {{ __('crud.edit') }}
                    </button>
                @endif
                @endcan

                @can('galleryManage', $campaign)
                <span data-tooltip data-title="{{ __('Use shift+click on images to bulk delete them.') }}">
                <button class="btn2 btn-sm btn-error btn-disabled " id="bulk-delete" data-toggle="dialog"  data-target="bulk-destroy-dialog">
                    <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
                </button></span>
                @endcan
            </div>

            <div class="search">
                <input type="text" class="" id="gallery-search" placeholder="{{ __('campaigns/gallery.placeholders.search') }}" data-url="{{ route('campaign.gallery.search', $campaign) }}" />
            </div>
        </div>

        @can('create', [\App\Models\Image::class, $campaign])
        <form id="gallery-form" method="post" action="{{ route('images.store', $campaign) }}" enctype="multipart/form-data" class="file-upload-form">
            {{ csrf_field() }}
            <div class="rounded uploader transition duration-150 text-center border-dotted border-2 p-4" id="uploader">

                <h4>{{ __('campaigns/gallery.uploader.well') }}</h4>

                <p>{{ __('campaigns/gallery.uploader.or') }}</p>

                <span class="btn2 btn-primary btn-sm fileinput-button relative overflow-hidden inline-block">
                    <x-icon class="plus"></x-icon>
                    <span>{{ __('campaigns/gallery.uploader.select_file') }}</span>
                    <input type="file" id="file-upload" name="file" class="absolute top-0 right-0 m-0 h-full cursor-pointer opacity-0" multiple />
                </span>

                <p class="my-2">{{ __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif, woff2', 'size' => Limit::readable()->upload()]) }}</p>


                <p class="text-error gallery-error hidden"></p>

                <div class="progress h-0.5 w-full bg-gray hidden">
                    <div class="h-0.5 bg-aqua" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <input type="hidden" name="folder_id" value="{{ $folder?->id }}" />
        </form>
        @endcan


        <div class="gallery">
            <div id="gallery-loader" class="text-center text-xl hidden">
                <x-icon class="load" />
            </div>
            <div id="gallery-content">
                <ul id="gallery-images" class="m-0 p-0 list-none flex gap-4 flex-wrap">
                    @include('gallery.images')
                </ul>
            </div>
        </div>

        {{ $images->appends(!empty($folder) ? ['folder_id' => $folder->id] : [])->onEachSide(0)->links() }}
    </x-grid>


    <input type="hidden" id="gallery-config" data-max="{{ ini_get('max_file_uploads') }}" data-error="{{ __('campaigns/gallery.errors.max', ['count' => ini_get('max_file_uploads')]) }}" />
@endsection

@section('scripts')
    @parent
    @vite('resources/js/story.js')
    @vite('resources/js/gallery.js')
@endsection

@section('modals')
    @parent
    <x-dialog id="new-folder" :loading="true"></x-dialog>

    <form method="POST" action="{{ route('campaign.gallery.bulk.delete', [$campaign]) }}" id="gallery-bulk">
    <x-dialog id="bulk-destroy-dialog" title="{{ __('crud.delete_modal.title') }}">
        <p class="max-w-md">{{ __('campaigns/gallery.bulk.destroy.confirm') }}</p>

        <x-dialog.footer dialog="1">
            <button class="btn2 btn-error" id="">{{ __('crud.delete_modal.confirm') }}</button>
        </x-dialog.footer>
    </x-dialog>
    @if ($folder)
        <input type="hidden" name="folder_id" value="{{ $folder->id }}">
    @endif
    </form>
@endsection
