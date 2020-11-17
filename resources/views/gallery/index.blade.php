<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Image $image
 */?>
@extends('layouts.app', [
    'title' => trans('campaigns/gallery.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        trans('campaigns/gallery.title', ['campaign' => $campaign->name]),
    ]
])

@section('content')

    <div class="box no-border">
        <div class="box-body">
            <button class="btn btn-primary" data-toggle="collapse" data-target="#uploader">
                {{ __('campaigns/gallery.uploader.add') }}
            </button>

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

            <p>{{ trans('crud.files.hints.limitations', ['formats' => 'jpg, png, gif', 'size' => auth()->user()->maxUploadSize(true)]) }}</p>


            <p class="text-red gallery-error" style="display:none"></p>

            <div class="progress" style="display: none">
                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
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
