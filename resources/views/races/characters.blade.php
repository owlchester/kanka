@extends('layouts.app', [
    'title' => trans('races.characters.title', ['name' => $model->name]),
    'description' => trans('races.characters.description'),
    'breadcrumbs' => [
        ['url' => route('races.show', $model), 'label' => $model->name],
        trans('races.show.tabs.characters')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include('races._menu', ['active' => 'characters'])
        </div>
        <div class="col-md-10 entity-main-block">
            @include('races.panels.characters')
        </div>
    </div>
@endsection
