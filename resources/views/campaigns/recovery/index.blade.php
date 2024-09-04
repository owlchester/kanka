@extends('layouts.app', [
    'title' => __('campaigns/recovery.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns/recovery.title') }}
            </h3>
            <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                    data-target="recovery-help">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </button>
        </div>
        <div id="recovery">
            <recovery
                api="{{ route('recovery.setup', [$campaign]) }}"
            ></recovery>
        </div>
    </div>

@endsection


@section('modals')
    @parent
    <x-dialog id="recovery-help" :title="__('campaigns.show.tabs.recovery')">
        <p>{!! __('campaigns/recovery.helper', ['count' => '<code>' . config('entities.hard_delete') . '</code>']) !!}</p>
    </x-dialog>

@endsection


@section('scripts')
    @parent
    @vite('resources/js/recovery/recovery.js')
@endsection
