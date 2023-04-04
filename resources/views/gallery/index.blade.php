<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Image $image
 * @var \App\Models\Image $folder
 */

$breadcrumbs[] = ['url' => route('campaign.gallery.index'), 'label' => __('campaigns/gallery.breadcrumb')];
if ($folder) {
    if (!empty($folder->folder_id)) {
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

    <div class="box no-border box-gallery">
        <div class="box-body">
            <button class="btn btn-primary" data-toggle="collapse" data-target="#uploader">
                <i class="fa-solid fa-upload"></i> {{ __('campaigns/gallery.uploader.add') }}
            </button>
            <button class="btn btn-default" data-toggle="modal" data-target="#modal-new-folder">
                <i class="fa-solid fa-folder"></i> {{ __('campaigns/gallery.uploader.new_folder') }}
            </button>

            @if(!empty($folder))
                <button class="btn btn-default" data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route('images.edit', $folder) }}">
                    <i class="fa-solid fa-pencil" aria-hidden="true"></i> {{ __('crud.edit') }}
                </button>
            @endif

            <div class="search pull-right">
                <input type="text" class="form-control" id="gallery-search" placeholder="{{ __('campaigns/gallery.placeholders.search') }}" data-url="{{ route('campaign.gallery.search') }}" />
            </div>
        </div>
    </div>

    <form id="gallery-form" method="post" action="{{ route('images.store') }}" enctype="multipart/form-data" class="file-upload-form mb-5">
        {{ csrf_field() }}
        <div class="uploader collapse !visible out well text-center border-dotted border-1 " id="uploader">

            <h4>{{ __('campaigns/gallery.uploader.well') }}</h4>

            <p>{{ __('campaigns/gallery.uploader.or') }}</p>

            <span class="btn btn-primary fileinput-button relative overflow-hidden inline-block">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                <span>{{ __('campaigns/gallery.uploader.select_file') }}</span>
                <input type="file" id="file-upload" name="file" class="absolute top-0 right-0 m-0 h-full cursor-pointer" multiple />
            </span>

            <p>{{ __('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif', 'size' => auth()->user()->maxUploadSize(true)]) }}</p>


            <p class="text-red gallery-error" style="display:none"></p>

            <div class="progress" style="display: none">
                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        @if(!empty($folder))
            {!! Form::hidden('folder_id', $folder->id) !!}
        @endif
    </form>


    <div class="gallery">
        <div id="gallery-loader" class="text-center" style="display: none">
            <i class="fa-solid fa-spinner fa-spin fa-4x"></i>
        </div>
        <div id="gallery-content">
            <ul id="gallery-images" class="m-0 p-0 list-none">
                @include('gallery.images')
            </ul>
        </div>
    </div>

    {{ $images->appends(!empty($folder) ? ['folder_id' => $folder->id] : [])->links() }}

    <div class="modal fade" id="modal-new-folder" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'campaign.gallery.folder', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('campaigns/gallery.new_folder.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('campaigns/gallery.fields.name') }}</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>

                    @include('cruds.fields.visibility_id', ['model' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">
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
    @vite('resources/js/gallery.js')
@endsection

@section('styles')
    @vite('resources/sass/gallery.scss')
@endsection
