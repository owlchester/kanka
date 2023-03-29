@extends('layouts.app', [
    'title' => __('campaigns/export.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.export')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'export'])
        </div>
        <div class="col-md-9">
            <h3 class="mt-0">
                <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                        data-target="export-help">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    {{ __('campaigns.members.actions.help') }}
                </button>

                {{ __('campaigns/export.title') }}
            </h3>

            @if ($campaign->exportable())
            <div class="row">
                <div class="col-sm-12 col-md-6 col-md-offset-3 text-center my-5">
                    <button class="btn btn-primary btn-large campaign-export-btn" data-url="{{ route('campaign.export-process') }}">
                        <i class="fa-solid fa-download" aria-hidden="true"></i>
                        {{ __('campaigns/export.actions.export') }}
                    </button>

                </div>
            </div>
            @else
            <div class="alert alert-warning">
                {{ __('campaigns/export.errors.limit') }}
            </div>
            @endif
        </div>
    </div>
@endsection

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'export-help',
        'title' => __('campaigns.show.tabs.export'),
        'textes' => [
            __('campaigns/export.helpers.intro'),
            __('campaigns/export.helpers.json'),
            __('campaigns/export.helpers.import', [
                'api' => link_to('/' . app()->getLocale() . config('larecipe.docs.route') . '/1.0/overview', __('front.features.api.link'), null, ['target' => '_blank'])
])
        ]
    ])

@endsection
