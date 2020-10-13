@extends('layouts.app', [
    'title' => trans('journals.journals.title', ['name' => $model->name]),
    'description' => trans('journals.journals.description'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('journals'), 'label' => __('journals.index.title')],
        ['url' => route('journals.show', $model), 'label' => $model->name],
        trans('journals.show.tabs.journals')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('journals._menu', ['active' => 'journals'])
        </div>
        <div class="col-md-9">
            @include('journals.panels.journals')
        </div>
    </div>
@endsection
