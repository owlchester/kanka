@extends('layouts.app', [
    'title' => __('campaigns/recovery.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'recovery'])
        </div>
        <div class="grow max-w-7xl">
            <div class="flex gap-2 items-center mb-5">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.recovery') }}
                </h3>
                <button class="btn btn-sm btn-default" data-toggle="dialog"
                        data-target="recovery-help">
                    <x-icon class="question"></x-icon>
                    {{ __('campaigns.members.actions.help') }}
                </button>
            </div>
            @if (session()->get('boosted-pitch'))
                <x-cta :campaign="$campaign">
                </x-cta>
            @endif

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
    <x-dialog id="recovery-help" :title="__('campaigns.show.tabs.recovery')">
        <p>{!! __('campaigns/recovery.helper', ['count' => '<code>' . config('entities.hard_delete') . '</code>']) !!}</p>
    </x-dialog>

@endsection

