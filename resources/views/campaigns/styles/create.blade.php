@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/styles.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign_styles.index', $campaign), 'label' => __('campaigns.show.tabs.styles')]
    ],
    'sidebar' => 'campaign',
])

@section('content')

    <x-form :action="['campaign_styles.store', $campaign]" id="campaign-style" :extra="['data-max-content' => \App\Http\Requests\StoreCampaignStyle::MAX, 'data-error' => '#max-content-error']">
    <x-box>
        <x-grid type="1/1">
            @include('partials.errors')

            @if (!$theme)
            <x-alert type="info">
                <p>{!! __('campaigns/builder.pitch') !!}</p>
                <a href="{{ route('campaign_styles.builder', $campaign) }}" class="btn2 btn-primary">
                    {{ __('campaigns/builder.pitch-go') }}
                </a>
            </x-alert>
            @endif

            <x-alert type="error" id="max-content-error" class="hidden">
                {{ __('campaigns/styles.errors.max_content', ['amount' => number_format(\App\Http\Requests\StoreCampaignStyle::MAX)]) }}
            </x-alert>

            @include('campaigns.styles._form')
        </x-grid>

        <x-dialog.footer>
            @include('campaigns.styles._form-footer')
        </x-dialog.footer>
    </x-box>
    </x-form>
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
