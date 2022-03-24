@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/styles.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign_styles.index'), 'label' => __('campaigns.show.tabs.styles')]
    ]
])

@section('content')
    <div class="panel panel-default">
        {!! Form::open([
            'route' => ['campaign_styles.store'],
            'method' => 'POST',
            'data-shortcut' => 1
        ]) !!}
        <div class="panel-body">
            @include('partials.errors')

            <div class="form-group required">
                <label>{{ __('campaigns/styles.fields.name') }}</label>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group required">
                <label>{{ __('campaigns/styles.fields.content') }}</label>
                {!! Form::textarea('content', null, ['class' => 'form-control codemirror', 'id' => 'css', 'spellcheck' => 'false']) !!}
                <p class="help-block">{{ __('campaigns.helpers.css') }}</p>
            </div>

            <div class="form-group">
                {!! Form::hidden('is_enabled', 0) !!}
                <div class="checkbox">
                    <label>{!! Form::checkbox('is_enabled', 1, !isset($style) ? true : $style->is_enabled) !!}
                        {{ __('campaigns/styles.fields.is_enabled') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-success">{{ __('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>

    {{ csrf_field() }}
    {!! Form::close() !!}
@endsection


@section('scripts')
    @parent
    <script src="/vendor/codemirror/lib/codemirror.js"></script>
    <script src="/vendor/codemirror/mode/css/css.js"></script>
    <script src="/vendor/codemirror/addon/hint/show-hint.js"></script>
    <script src="/vendor/codemirror/addon/hint/css-hint.js"></script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="/vendor/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/vendor/codemirror/addon/hint/show-hint.css">
    <link rel="stylesheet" href="/vendor/codemirror/theme/dracula.css">
@endsection
