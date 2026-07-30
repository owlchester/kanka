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

            <x-alert type="error" id="max-content-error" class="hidden">
                {{ __('campaigns/styles.errors.max_content', ['amount' => \Illuminate\Support\Number::format(\App\Http\Requests\StoreCampaignStyle::MAX)]) }}
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
    @vite('resources/js/campaigns/style-editor.js')
@endsection
