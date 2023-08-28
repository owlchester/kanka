@extends('layouts.app', [
    'title' => __('campaigns/recovery.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')

    <div class="flex gap-5 flex-col max-w-7xl">
        @include('partials.errors')
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.recovery') }}
            </h3>
            <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                    data-target="recovery-help">
                <x-icon class="question"></x-icon>
                {{ __('crud.actions.help') }}
            </button>
        </div>
        @if (session()->get('boosted-pitch'))
            <x-cta :campaign="$campaign">
            </x-cta>
        @endif

        @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['recovery.save', $campaign]]) !!} @endif
        <div id="datagrid-parent">
            @include('layouts.datagrid._table')
        </div>
        @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
    </div>
@endsection


@section('modals')
    @parent
    <x-dialog id="recovery-help" :title="__('campaigns.show.tabs.recovery')">
        <p>{!! __('campaigns/recovery.helper', ['count' => '<code>' . config('entities.hard_delete') . '</code>']) !!}</p>
    </x-dialog>

@endsection

