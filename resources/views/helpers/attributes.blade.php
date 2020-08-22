@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('helpers.title'),
    'breadcrumbs' => [
        __('helpers.attributes.title')
    ]
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h4>{{ __('helpers.attributes.title') }}</h4>
        </div>

        <div class="box-body">
            <p>
                {!! __('helpers.attributes.description', [
                    'mention' => '<code>[entity:id]</code>',
                    'attribute' => '<code>{' . __('helpers.attributes.level') . '}</code>',
                ]) !!}
            </p>
            <p>
                {!! __('helpers.attributes.math', [
                    'example' => '<code>{' . __('helpers.attributes.level') . '}*{Con}</code>',
                    'floor' => '<code>floor({' . __('helpers.attributes.level') . '}/3)</code>',
                    'ceil' => '<code>ceil(({Con}*{' . __('helpers.attributes.level') . '})/2)</code>',
                ]) !!}
            </p>
        </div>
    </div>
@endsection
