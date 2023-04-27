@extends('layouts.app', [
    'title' => trans('races.characters.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('races'), 'label' => \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races'))],
        ['url' => $model->getLink(), 'label' => $model->name],
        \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

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
