@extends('layouts.app', [
    'title' => __('characters.organisations.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('entity-header-actions')

    @can('organisation', [$model, 'add'])
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="{{ route('characters.character_organisations.create', ['character' => $model->id]) }}"
               class="btn btn-sm btn-warning" data-toggle="ajax-modal"
               data-target="#entity-modal" data-url="{{ route('characters.character_organisations.create', $model->id) }}">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('characters.organisations.actions.add')  }}
            </a>
        </div>
    @endcan
@endsection

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('characters'), 'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))],
                null
            ]
        ])

        @include('characters._menu', ['active' => 'organisations'])

        <div class="entity-main-block">
            @include('characters.panels.organisations')
        </div>
    </div>
@endsection
