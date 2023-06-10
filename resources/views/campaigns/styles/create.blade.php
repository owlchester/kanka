@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/styles.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign_styles.index'), 'label' => __('campaigns.show.tabs.styles')]
    ]
])

@section('content')

    {!! Form::open([
        'route' => ['campaign_styles.store'],
        'method' => 'POST',
        'data-shortcut' => 1,
        'id' => 'campaign-style',
        'data-max-content' => \App\Http\Requests\StoreCampaignStyle::MAX,
        'data-error' => '#max-content-error'
    ]) !!}
    <x-box>
        @include('partials.errors')

        <x-alert type="info">
            <p>{!! __('campaigns/builder.pitch') !!}</p>
            <a href="{{ route('campaign_styles.builder') }}" class="btn2 btn-primary">
                {{ __('campaigns/builder.pitch-go') }}
            </a>
        </x-alert>

        <x-alert type="error" id="max-content-error" :hidden="true">
            {{ __('campaigns/styles.errors.max_content', ['amount' => number_format(\App\Http\Requests\StoreCampaignStyle::MAX)]) }}
        </x-alert>

        <x-grid type="1/1">
            <div class="field-name required">
                <label>{{ __('campaigns/styles.fields.name') }}</label>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>


            <div class="field-content required">
                <label>{{ __('campaigns/styles.fields.content') }}</label>
                {!! Form::textarea('content', null, ['class' => 'form-control codemirror', 'id' => 'css', 'spellcheck' => 'false']) !!}
                <p class="help-block">{{ __('campaigns.helpers.css') }}</p>
            </div>

            <div class="field-enabled">
                {!! Form::hidden('is_enabled', 0) !!}
                <div class="checkbox">
                    <label>{!! Form::checkbox('is_enabled', 1, !isset($style) ? true : $style->is_enabled) !!}
                        {{ __('campaigns/styles.fields.is_enabled') }}
                    </label>
                </div>
            </div>
        </x-grid>

        <x-dialog.footer>
            <div class="submit-group">
                <input id="submit-mode" type="hidden" value="true"/>
                <div class="join">
                    <button class="btn2 btn-primary join-item" id="form-submit-main">
                        {{ __('crud.save') }}
                    </button>
                    <div class="dropdown">
                        <button type="button" class="btn2 btn-primary join-item dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li>
                                <a href="#" class="dropdown-item form-submit-actions">
                                    {{ __('crud.save') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item form-submit-actions" data-action="submit-update">
                                    {{ __('crud.save_and_update') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-dialog.footer>
    </x-box>

    {{ csrf_field() }}
    {!! Form::close() !!}
@endsection


@section('scripts')
    @parent
    <script src="/vendor/codemirror/lib/codemirror.js"></script>
    <script src="/vendor/codemirror/mode/css/css.js"></script>
    <script src="/vendor/codemirror/addon/hint/show-hint.js"></script>
    <script src="/vendor/codemirror/addon/hint/css-hint.js"></script>
    <script src="/vendor/codemirror/addon/search/search.js"></script>
    <script src="/vendor/codemirror/addon/search/searchcursor.js"></script>
    <script src="/vendor/codemirror/addon/dialog/dialog.js"></script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="/vendor/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/vendor/codemirror/addon/hint/show-hint.css">
    <link rel="stylesheet" href="/vendor/codemirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="/vendor/codemirror/theme/dracula.css">
@endsection
