@extends('layouts.app', [
    'title' => __('items.inventories.title', ['name' => $model->name]),
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
                ['url' => Breadcrumb::index('items'), 'label' => \App\Facades\Module::plural(config('entities.ids.item'), __('entities.items'))],
                __('items.show.tabs.inventories')
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'inventories'])

        <div class="entity-main-block">
            @include('items.panels.entities')
        </div>
    </div>
@endsection
