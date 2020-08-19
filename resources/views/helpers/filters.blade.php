@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('helpers.title'),
    'breadcrumbs' => [
        __('helpers.filters.title')
    ]
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h4>{{ __('helpers.filters.title') }}</h4>
        </div>

        <div class="box-body">
            <p>{{ __('helpers.filters.description') }}</p>
            <dl class="dl-horizontal">
                <dt><code>!...</code></dt>
                <dd>{!! __('helpers.filters.starting_with', ['tag' => '<code>!</code>']) !!}</dd>

                <dt><code>...!</code></dt>
                <dd>{!! __('helpers.filters.ending_with', ['tag' => '<code>!</code>']) !!}</dd>

                <dt><code>!!</code></dt>
                <dd>{!! __('helpers.filters.empty', ['tag' => '<code>!!</code>']) !!}</dd>
            </dl>

            <p>{{ __('helpers.filters.session') }}</p>
        </div>
    </div>
@endsection
