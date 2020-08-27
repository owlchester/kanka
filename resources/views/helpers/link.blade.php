@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('helpers.title'),
    'breadcrumbs' => [
        trans('helpers.link.title')
    ]
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h4>{{ trans('helpers.link.title') }}</h4>
        </div>

        <div class="box-body">
            <p>
                {{ trans('helpers.link.description') }}
            </p>
            <p>
                {!! trans('helpers.link.friendly_mentions', [
                    'code' => '<code>@</code>',
                    'example' => '<code>Entity Name</code>'
                ]) !!}
            </p>
            <p>
                {!! trans('helpers.link.mentions', [
                    'code' => '<code>[</code>',
                    'example' => '<code>[entity:123]</code>',
                    'example_name' => '<code>[entity:123|Alex]</code>',
                    'example_page' => '<code>[entity:123|page:inventory]</code>',
                    'example_tab' => '<code>[entity:123|tab:relations]</code>',
                ]) !!}
            </p>
            <p>
                {!! trans('helpers.link.months', [
                    'code' => '<code>#</code>'
                ]) !!}
            </p>
            <p>
                {!! trans('helpers.link.attributes', [
                    'code' => '<code>{</code>'
                ]) !!}
            </p>
            <p class="info">{{ __('helpers.link.limitations') }}</p>

            <hr />

            <h4>{{ __('helpers.link.formatting.title') }}</h4>
            <p>{!! __('helpers.link.formatting.text', ['github' => '<a href="https://github.com/ilestis/miscellany/blob/develop/config/purify.php" target="_blank">Github</a>']) !!}</p>
        </div>
    </div>
@endsection
