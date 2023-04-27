@extends('layouts.app', [
    'title' => __('journals.journals.title', ['name' => $model->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@php
$plural = \App\Facades\Module::plural(config('entities.ids.journal'), __('entities.journals'));
@endphp
@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('journals'), 'label' => $plural],
                __('entities.children')
            ]
        ])

        @include('journals._menu', ['active' => 'journals'])

        <div class="entity-main-block">
            @include('journals.panels.journals')
        </div>
    </div>
@endsection

