@extends('layouts.app', [
    'title' => __('journals.journals.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('journals'), 'label' => __('journals.index.title')],
                __('journals.show.tabs.journals')
            ]
        ])

        @include('journals._menu', ['active' => 'journals'])

        <div class="entity-main-block">
            @include('journals.panels.journals')
        </div>
    </div>
@endsection

