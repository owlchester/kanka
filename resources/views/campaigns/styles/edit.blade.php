@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/styles.update.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign_styles.index', $campaign), 'label' => __('campaigns.show.tabs.styles')]
    ],
    'sidebar' => 'campaign',
])

@section('content')
    {!! Form::model($style, [
        'route' => ['campaign_styles.update', $campaign, $style],
        'method' => 'PATCH',
        'data-shortcut' => 1,
        'id' => 'campaign-style',
        'data-max-content' => \App\Http\Requests\StoreCampaignStyle::MAX,
        'data-error' => '#max-content-error'
    ]) !!}
    <x-box>
        <x-grid type="1/1">
            @include('partials.errors')

            <x-alert type="error" id="max-content-error" :hidden="true">
                {{ __('campaigns/styles.errors.max_content', ['amount' => number_format(\App\Http\Requests\StoreCampaignStyle::MAX)]) }}
            </x-alert>

            @include('campaigns.styles._form')
        </x-grid>
        <x-dialog.footer>
            @include('campaigns.styles._form-footer')
        </x-dialog.footer>
    </x-box>

    {{ csrf_field() }}
    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/lib/codemirror.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/mode/css/css.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/addon/hint/show-hint.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/addon/hint/css-hint.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/addon/search/search.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/addon/search/searchcursor.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/codemirror/addon/dialog/dialog.js"></script>
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/codemirror/addon/hint/show-hint.css">
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/codemirror/addon/dialog/dialog.css">
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/codemirror/theme/dracula.css">
@endsection
