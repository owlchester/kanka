@extends('layouts.app', [
    'title' => __('campaigns/recovery.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => trans('campaigns.index.title')],
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'recovery'])
        </div>
        <div class="col-md-9">
            @if (!$campaign->boosted())
                <h3 class="mt-0">
                    <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                            data-target="recovery-help">
                        <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                        {{ __('campaigns.members.actions.help') }}
                    </button>
                    {{ __('campaigns.show.tabs.recovery') }}
                </h3>

                @include('partials.boosted', ['callout' => true])

                <div class="row">
                    <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                        @include('partials.images.boosted-image')
                    </div>
                </div>
            @else

            <div class="box box-recovery">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('campaigns.show.tabs.recovery') }}</h3>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-toggle="dialog"
                                data-target="recovery-help">
                            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                            {{ __('campaigns.members.actions.help') }}
                        </button>
                    </div>
                </div>
                @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'recovery.save']) !!} @endif
                <div id="datagrid-parent">
                    @include('layouts.datagrid._table')
                </div>
                @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

            @endif
        </div>
    </div>
@endsection


@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'recovery-help',
        'title' => __('campaigns.show.tabs.recovery'),
        'textes' => [
            __('campaigns/recovery.helper', ['count' => '<code>' . config('entities.hard_delete') . '</code>'])
        ]
    ])
@endsection

