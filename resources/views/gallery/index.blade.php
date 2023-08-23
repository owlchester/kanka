<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Image $image
 * @var \App\Models\Image $folder
 */

$breadcrumbs[] = ['url' => route('campaign.gallery.index', $campaign), 'label' => __('campaigns/gallery.breadcrumb')];
if ($folder) {
    if (!empty($folder->folder_id)) {
        if (!empty($folder->imageFolder->folder_id)) {
            $breadcrumbs[] = '...';
        }
        $breadcrumbs[] = ['url' => route('campaign.gallery.index', [$campaign, 'folder_id' => $folder->folder_id]), 'label' => e($folder->imageFolder->name)];
    }
    $breadcrumbs[] = e($folder->name);
}
?>
@extends('layouts.app', [
    'title' => __('campaigns/gallery.breadcrumb') . ' - ' . $campaign->name,
    'breadcrumbs' => $breadcrumbs,
    'bodyClass' => 'campaign-gallery',
    'mainTitle' => false,
])

@section('content')
<div class="flex items-center gap-2">
    <div class="grow">
        <button class="btn2 btn-primary btn-sm" data-toggle="collapse" data-target="#uploader">
            <x-icon class="fa-solid fa-upload"></x-icon> {{ __('campaigns/gallery.uploader.add') }}
        </button>
        <button class="btn2 btn-sm" data-toggle="dialog" data-target="new-folder">
            <x-icon class="fa-solid fa-folder"></x-icon> {{ __('campaigns/gallery.uploader.new_folder') }}
        </button>

        @if(!empty($folder))
            <button class="btn2 btn-sm" data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route('images.edit', [$campaign, $folder]) }}">
                <x-icon class="pencil"></x-icon> {{ __('crud.edit') }}
            </button>
        @endif
        <button class="btn2 btn-sm btn-error" style="display: none" id="bulk-delete" data-toggle="dialog" data-target="bulk-destroy-dialog">
            <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
        </button>
    </div>

    <div class="search">
        <input type="text" class="form-control" id="gallery-search" placeholder="{{ __('campaigns/gallery.placeholders.search') }}" data-url="{{ route('campaign.gallery.search', $campaign) }}" />
    </div>
</div>

    <form id="gallery-form" method="post" action="{{ route('images.store', $campaign) }}" enctype="multipart/form-data" class="file-upload-form mb-5">
        {{ csrf_field() }}
        <div class="uploader collapse !visible out well text-center border-dotted border-2 p-4 " id="uploader">

            <h4>{{ __('campaigns/gallery.uploader.well') }}</h4>

            <p>{{ __('campaigns/gallery.uploader.or') }}</p>

            <span class="btn2 btn-primary btn-sm fileinput-button relative overflow-hidden inline-block">
                <x-icon class="plus"></x-icon>
                <span>{{ __('campaigns/gallery.uploader.select_file') }}</span>
                <input type="file" id="file-upload" name="file" class="absolute top-0 right-0 m-0 h-full cursor-pointer opacity-0" multiple />
            </span>

            <p class="my-2">{{ __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif, woff2', 'size' => Limit::readable()->upload()]) }}</p>


            <p class="text-red gallery-error" style="display:none"></p>

            <div class="progress h-0.5 w-full bg-gray" style="display: none">
                <div class="h-0.5 bg-aqua" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        {!! Form::hidden('folder_id', $folder?->id) !!}
    </form>


    <div class="gallery">
        <div id="gallery-loader" class="text-center text-xl" style="display: none">
            <x-icon class="load" />
        </div>
        <div id="gallery-content">
            <ul id="gallery-images" class="m-0 p-0 list-none flex gap-2 md:gap-5 flex-wrap">
                @include('gallery.images')
            </ul>
        </div>
    </div>

    {{ $images->appends(!empty($folder) ? ['folder_id' => $folder->id] : [])->onEachSide(0)->links() }}



    <input type="hidden" id="gallery-config" data-max="{{ ini_get('max_file_uploads') }}" data-error="{{ __('campaigns/gallery.errors.max', ['count' => ini_get('max_file_uploads')]) }}" />
@endsection

@section('scripts')
    @parent
    @vite('resources/js/story.js')
    @vite('resources/js/gallery.js')
@endsection

@section('modals')
    @parent
    <x-dialog id="new-folder" title="{{ __('campaigns/gallery.new_folder.title') }}">
        {!! Form::open(['route' => ['campaign.gallery.folder', $campaign], 'method' => 'POST', 'class' => 'ajax-subform']) !!}
            <x-grid type="1/1">
                <div class="field-name">
                    <label>{{ __('campaigns/gallery.fields.name') }}</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100, 'required']) !!}
                </div>

                @include('cruds.fields.visibility_id', ['model' => null])
            </x-grid>
            <div class="flex flex-wrap gap-3 justify-between items-start my-5">
                <menu class="flex flex-wrap gap-3 ps-0 ms-0">
                    <button autofocus type="button" class="btn2 btn-ghost btn-full" onclick="this.closest('dialog').close('close')">
                        {{ __('crud.cancel') }}
                    </button>
                </menu>
                <menu class="flex flex-wrap gap-3 ps-0">
                    <button type="submit" class="btn2 btn-primary">
                        {{ __('crud.create') }}
                    </button>
                </menu>
            </div>
        @if(!empty($folder))
            {!! Form::hidden('folder_id', $folder->id) !!}
        @endif
        {!! Form::close() !!}
    </x-dialog>

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
