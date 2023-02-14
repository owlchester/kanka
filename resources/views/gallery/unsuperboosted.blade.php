@php $breadcrumbs[] = ['url' => route('gallery.index', [$campaign]), 'label' => __('campaigns/gallery.breadcrumb')];
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/gallery.breadcrumb') . ' - ' . $campaign->name,
    'breadcrumbs' => $breadcrumbs,
    'bodyClass' => 'campaign-gallery',
    'mainTitle' => false,
])


@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            @include('partials.superboosted', ['callout' => true])
            @include('partials.images.boosted-image')
        </div>
    </div>
@endsection
