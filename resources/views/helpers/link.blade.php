@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('helpers.title'),
    'breadcrumbs' => [
        __('helpers.link.title')
    ]
])

@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h4>{{ __('helpers.link.title') }}</h4>
        </div>

        <div class="box-body">
            <p>
                {{ __('helpers.link.description') }}
            </p>
            <p>
                {!! __('helpers.link.friendly_mentions', [
                    'code' => '<code>@</code>',
                    'example' => '<code>Entity Name</code>'
                ]) !!}
            </p>
            <p>
                {!! __('helpers.link.mention_helpers', [
                    'example' => '<code>_</code>',
                    'exact' => '<code>=Entity Name</code>'
                ]) !!}
            </p>
            <p>
                {!! __('helpers.link.mentions', [
                    'code' => '<code>[</code>',
                    'example' => '<code>[entity:123]</code>',
                    'example_name' => '<code>[entity:123|Alex]</code>',
                    'example_page' => '<code>[entity:123|page:inventory]</code>',
                ]) !!}
                {!! __('helpers.link.options', [
    'options' => '<code>' . implode('</code>, <code>', ['inventory', 'attributes', 'abilities', 'assets', 'relations', 'profile']) . '</code>'
]) !!}
            </p>

            <p>
                {!! __('helpers.link.anchor', [
                    'example' => '<code>[entity:123|anchor:entity-note-69]</code>',
                ]) !!}
            </p>

            <p>
                {!! __('helpers.link.mentions_field', [
                    'code' => '<code>[entity:123|field:location]</code>',
                ]) !!}
                {!! __('helpers.link.options', [
    'options' => '<code>' . implode('</code>, <code>', ['type', 'location', 'race', 'gender', 'pronouns', 'title']) . '</code>'
]) !!}
            </p>

            <p>
                {!! __('helpers.link.months', [
                    'code' => '<code>#</code>'
                ]) !!}
            </p>
            <p>
                {!! __('helpers.link.attributes', [
                    'code' => '<code>{</code>'
                ]) !!}
            </p>
            <p class="helo-block">{{ __('helpers.link.limitations') }}</p>

            <hr />

            <h4>{{ __('helpers.link.formatting.title') }}</h4>
            <p>{!! __('helpers.link.formatting.text', ['github' => '<a href="https://github.com/ilestis/miscellany/blob/develop/config/purify.php" target="_blank">Github</a>']) !!}</p>
        </div>
    </div>
@endsection
