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

            <div class="box box-recovery">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('campaigns.show.tabs.recovery') }}</h3>

                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" data-toggle="modal"
                                data-target="#recovery-help">
                            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                            {{ __('campaigns.members.actions.help') }}
                        </button>
                    </div>
                </div>

            @if ($campaign->boosted())

                @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'recovery.save']) !!} @endif
                <div id="datagrid-parent">
                    @include('layouts.datagrid._table')
                </div>
                @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

            @else
                <div class="box-body">
                    <p class="help-block">{{ __('campaigns/recovery.helper', ['count' => config('entities.hard_delete')]) }}</p>

                    @include('partials.boosted', ['callout' => true])
                </div>
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

