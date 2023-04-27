@extends('layouts.app', [
    'title' => __('locations.characters.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('locations'), 'label' => \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations'))],
                \App\Facades\Module::plural(config('entities.ids.character'), __('entities.locations'))
            ]
        ])

        @include('locations._menu', ['active' => 'characters'])

        <div class="entity-main-block">
            @include('locations.panels.characters')
        </div>
    </div>
@endsection
