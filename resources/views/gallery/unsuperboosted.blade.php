@php $breadcrumbs[] = ['url' => route('gallery', $campaign), 'label' => __('campaigns/gallery.breadcrumb')];
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/gallery.breadcrumb') . ' - ' . $campaign->name,
    'breadcrumbs' => $breadcrumbs,
    'bodyClass' => 'campaign-gallery',
    'mainTitle' => false,
])


@section('content')
    <x-cta :campaign="$campaign" superboost="true">
        <p>{{ __('campaigns/gallery.cta') }}</p>
    </x-cta>
@endsection
