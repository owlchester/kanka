<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Image $image
 * @var \App\Models\Image $folder
 */

$breadcrumbs[] = ['url' => route('campaign.gallery.index'), 'label' => __('campaigns/gallery.breadcrumb')];
if ($folder) {
    if (!empty($folder->folder_id)) {
        if (!empty($folder->imageFolder->folder_id)) {
            $breadcrumbs[] = '...';
        }
        $breadcrumbs[] = ['url' => route('campaign.gallery.index', ['folder_id' => $folder->folder_id]), 'label' => e($folder->imageFolder->name)];
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
<div class="flex items-center gap-2 mb-2">
    <div class="grow">
        <button class="btn2 btn-primary btn-sm" data-toggle="collapse" data-target="#uploader">
            <x-icon class="fa-solid fa-upload"></x-icon> {{ __('campaigns/gallery.uploader.add') }}
        </button>
        <button class="btn2 btn-sm" data-toggle="modal" data-target="#modal-new-folder">
            <x-icon class="fa-solid fa-folder"></x-icon> {{ __('campaigns/gallery.uploader.new_folder') }}
        </button>

        @if(!empty($folder))
            <button class="btn2 btn-sm" data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route('images.edit', $folder) }}">
                <x-icon class="pencil"></x-icon> {{ __('crud.edit') }}
            </button>
        @endif
    </div>

    <div class="search">
        <input type="text" class="form-control" id="gallery-search" placeholder="{{ __('campaigns/gallery.placeholders.search') }}" data-url="{{ route('campaign.gallery.search') }}" />
    </div>
</div>

    <form id="gallery-form" method="post" action="{{ route('images.store') }}" enctype="multipart/form-data" class="file-upload-form mb-5">
        {{ csrf_field() }}
        <div class="uploader collapse !visible out well text-center border-dotted border-2 p-4 " id="uploader">

            <h4>{{ __('campaigns/gallery.uploader.well') }}</h4>

            <p>{{ __('campaigns/gallery.uploader.or') }}</p>

            <span class="btn2 btn-primary btn-sm fileinput-button relative overflow-hidden inline-block">
                <x-icon class="plus"></x-icon>
                <span>{{ __('campaigns/gallery.uploader.select_file') }}</span>
                <input type="file" id="file-upload" name="file" class="absolute top-0 right-0 m-0 h-full cursor-pointer opacity-0" multiple />
            </span>

            <p class="my-2">{{ __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif, woff2', 'size' => auth()->user()->maxUploadSize(true)]) }}</p>


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
        <div id="gallery-loader" class="text-center" style="display: none">
            <i class="fa-solid fa-spinner fa-spin fa-4x" aria-hidden="true"></i>
        </div>
        <div id="gallery-content">
            <ul id="gallery-images" class="m-0 p-0 list-none flex gap-2 md:gap-5 flex-wrap">
                @include('gallery.images')
            </ul>
        </div>
    </div>

    {{ $images->appends(!empty($folder) ? ['folder_id' => $folder->id] : [])->links() }}

    <div class="modal fade" id="modal-new-folder" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100">
                {!! Form::open(['route' => 'campaign.gallery.folder', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <x-dialog.close />
                    <h4 class="modal-title" id="myModalLabel">{{ __('campaigns/gallery.new_folder.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="field-name">
                        <label>{{ __('campaigns/gallery.fields.name') }}</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>

                    @include('cruds.fields.visibility_id', ['model' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn2 btn-sm" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="submit" class="btn2 btn-sm btn-primary">
                    {{ __('crud.create') }}
                </button>
                </div>
            </div>
            @if(!empty($folder))
                {!! Form::hidden('folder_id', $folder->id) !!}
            @endif
            {!! Form::close() !!}
        </div>
    </div>

    <input type="hidden" id="gallery-config" data-max="{{ ini_get('max_file_uploads') }}" data-error="{{ __('campaigns/gallery.errors.max', ['count' => ini_get('max_file_uploads')]) }}" />
@endsection

@section('scripts')
    @parent
    @vite('resources/js/story.js')
    @vite('resources/js/gallery.js')
@endsection
