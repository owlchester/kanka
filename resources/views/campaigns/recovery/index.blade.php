@extends('layouts.app', [
    'title' => __('campaigns/recovery.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
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
            <div class="mb-1">
                <h3 class="mt-0 inline-block">
                    {{ __('campaigns.show.tabs.recovery') }}
                </h3>
                <button class="btn btn-sm btn-default pull-right" data-toggle="dialog"
                        data-target="recovery-help">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    {{ __('campaigns.members.actions.help') }}
                </button>
            </div>

            @includeWhen(session()->get('boosted-pitch'), 'layouts.callouts.boost', ['texts' => []])

            <div class="box box-recovery">
                @if(Datagrid::hasBulks()) {!! Form::open(['route' => 'recovery.save']) !!} @endif
                <div id="datagrid-parent">
                    @include('layouts.datagrid._table')
                </div>
                @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
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

