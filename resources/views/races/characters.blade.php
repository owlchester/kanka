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
    <div class="row">
        <div class="col-md-3">
            @include('races._menu', ['active' => 'characters'])
        </div>
        <div class="col-md-9">
            @include('races.panels.characters')
        </div>
    </div>
@endsection
