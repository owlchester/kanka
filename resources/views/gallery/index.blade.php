<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Image $image
 */?>
@extends('layouts.app', [
    'title' => trans('campaigns/gallery.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        __('campaigns/gallery.title', ['campaign' => $campaign->name]),
    ],
    'bodyClass' => 'campaign-gallery',
])

@section('content')

    <div class="box no-border box-gallery">
        <div class="box-body">
            <button class="btn btn-primary" data-toggle="collapse" data-target="#uploader">
                <i class="fa fa-upload"></i> {{ __('campaigns/gallery.uploader.add') }}
            </button>
            <button class="btn btn-default" data-toggle="modal" data-target="#modal-new-folder">
                <i class="fa fa-folder"></i> {{ __('campaigns/gallery.uploader.new_folder') }}
            </button>

            @if(!empty($folder))
                <button class="btn btn-default" data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ route('images.edit', $folder) }}">
                    <i class="fa fa-pencil"></i> {{ __('crud.edit') }}
                </button>
            @endif

            <div class="search pull-right">
                <input type="text" class="form-control" id="gallery-search" placeholder="{{ __('campaigns/gallery.placeholders.search') }}" data-url="{{ route('campaign.gallery.search') }}" />
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('images.store') }}" enctype="multipart/form-data" class="file-upload-form">
        {{ csrf_field() }}
        <div class="uploader collapse out well text-center" id="uploader">
            <a href="#" class="pull-right" data-toggle="collapse" data-target="#uploader">
                <i class="fa fa-times"></i>
            </a>

            <h4>{{ __('campaigns/gallery.uploader.well') }}</h4>

            <p>{{ __('campaigns/gallery.uploader.or') }}</p>

            <span class="btn btn-primary fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>
              <span>{{ __('campaigns/gallery.uploader.select_file') }}</span>
              <input type="file" id="file-upload" name="file" multiple />
        </span>

            <p>{{ trans('crud.files.hints.limitations', ['formats' => 'jpg, png, webp, gif', 'size' => auth()->user()->maxUploadSize(true)]) }}</p>


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
            <i class="fa fa-spinner fa-spin fa-4x"></i>
        </div>
        <div id="gallery-content">
            <ul id="gallery-images">
                @include('gallery.images')
            </ul>
        </div>
    </div>

    {{ $images->links() }}

    <div class="modal fade" id="modal-new-folder" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'campaign.gallery.folder', 'method' => 'POST']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('campaigns/gallery.new_folder.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('campaigns/gallery.fields.name') }}</label>
                        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
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
@endsection

@section('scripts')
    <script src="{{ mix('js/gallery.js') }}" defer></script>
    <script src="{{ mix('js/jquery.fileupload.js') }}" defer></script>
    <script src="{{ mix('js/jquery.iframe-transport.js') }}" defer></script>
    <script src="{{ mix('js/vendor/jquery.ui.widget.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/gallery.css') }}" rel="stylesheet">
@endsection
