@extends('layouts.app', [
    'title' => __('search/fulltext.title'),
    'seoTitle' => __('search/fulltext.title') . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-fulltext',
])


@section('content')
    @include('partials.errors')

    <div class="flex flex-col gap-5">
        <div class="flex gap-2 items-center justify-between">
            <h1 class="text-2xl category-title">{{ __('search/fulltext.title') }}</h1>
            <x-learn-more url="advanced/fulltext-search.html" />
        </div>
        @include('layouts.datagrid.fulltext_search', ['route' => route('search.fulltext', $campaign), 'term' => $term])

        @if ($searchMaintenance)
            <div class="alert alert-info" role="status">{{ __('search/fulltext.maintenance') }}</div>
        @endif

        @include('ads.top')

        @if (!empty($term) && !$searchMaintenance)
            <p class="text-lg">{!! __('search/fulltext.searching', ['term' => '<span class="italic">' . $term . '</span>']) !!}</p>
        @endif

        @include('cruds.datagrids.explore', ['flat' => true, 'skipPaginationHelper' => true])

    </div>
@endsection

