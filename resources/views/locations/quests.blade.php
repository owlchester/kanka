@extends('layouts.app', [
    'title' => trans('locations.quests.title', ['name' => $model->name]),
    'description' => trans('locations.quests.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('locations.index.title')],
        ['url' => route('locations.show', $model), 'label' => $model->name],
        trans('locations.show.tabs.quests')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('locations._menu', ['active' => 'quests'])
        </div>
        <div class="col-md-9">
            @include('locations.panels.quests')
        </div>
    </div>
@endsection
