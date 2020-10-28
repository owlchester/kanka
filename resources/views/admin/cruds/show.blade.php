@extends('layouts.admin', [
    'title' => trans($trans . '.show.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route($route . '.index'), 'label' => trans($trans . '.index.title')],
        $model->name,
    ]
])


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('partials.errors')

            @include($view . '.show')
        </div>
    </div>
@endsection

@include('editors.summernote')
