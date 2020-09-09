@extends('layouts.app', [
    'title' => trans('characters.maps.title', ['name' => $model->name]),
    'description' => trans('characters.maps.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => __('characters.index.title')],
        ['url' => route('characters.show', $model), 'label' => $model->name],
        trans('characters.show.tabs.maps')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('characters._menu', ['active' => 'map'])
        </div>
        <div class="col-md-9">
            <h2 class="page-header with-border">
                {{ trans('characters.show.tabs.map') }}
            </h2>

            <div style="display: block; height: 700px; width: 100%; overflow: auto;">
            <svg width="900" height="900" class="character-map-svg" data-url="{{ route('characters.map_data', $model) }}">
            </svg>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
    .links line {
        stroke: #999;
        stroke-opacity: 0.6;
    }

    .nodes circle {
        stroke: #fff;
        stroke-width: 1.5px;
    }

    .texts text {
        fill: #fff;
        font-size: 12pt;
        text-anchor: middle;
    }
    </style>
@endsection
@section('scripts')
    <script src="https://d3js.org/d3.v4.min.js" defer></script>
    <script src="{{ mix('js/character-map.js') }}" defer></script>
@endsection
