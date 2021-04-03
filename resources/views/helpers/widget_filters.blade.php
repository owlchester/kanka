@extends('layouts.app', [
    'title' => __('helpers.widget-filters.title'),
    'breadcrumbs' => false,
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h4>{{ __('helpers.widget-filters.title') }}</h4>
        </div>

        <div class="box-body">
            <p>
                {!! __('helpers.widget-filters.description', [
    'example' => '<code>is_dead=1&type=NPC</code>',
]) !!}
            </p>
            <p>
                {!! __('helpers.widget-filters.more', [
    'question' => '<code>?</code>',
]) !!}
            </p>
        </div>
    </div>
@endsection
