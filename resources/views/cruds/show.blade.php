<?php /** @var \App\Models\MiscModel $model */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.show.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        $model->name,
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('og')
    <meta property="og:description" content="{{ $model->tooltip() ?: trans($name . '.show.title', ['name' => $model->name]) }}" />
    @if ($model->image)<meta property="og:image" content="{{ Storage::url($model->image)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@section('content')
    @include($name . '.show')
@endsection


@section('scripts')
    <script src="{{ mix('js/entity.js') }}" defer></script>
    <script src="{{ mix('js/jquery.fileupload.js') }}" defer></script>
    <script src="{{ mix('js/jquery.iframe-transport.js') }}" defer></script>
    <script src="{{ mix('js/vendor/jquery.ui.widget.js') }}" defer></script>
@endsection
