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
<x-form :action="['recovery.save', $campaign]">
    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                    {{ __('campaigns/recovery.title') }}
            </h3>
            <button type="submit" class="btn2 btn-primary">
                <x-icon class="fa-solid fa-rotate" />
                {{ __('campaigns/recovery.actions.recover') }}
            </button>
            <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                    data-target="recovery-help">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </button>
        </div>
        @if (session()->get('boosted-pitch'))
            <x-cta :campaign="$campaign">
            </x-cta>
        @endif
        @include('campaigns.recovery._table')
    </div>
</x-form>

@endsection


@section('modals')
    @parent
    <x-dialog id="recovery-help" :title="__('campaigns.show.tabs.recovery')">
        <p>{!! __('campaigns/recovery.helper', ['count' => '<code>' . config('entities.hard_delete') . '</code>']) !!}</p>
    </x-dialog>

@endsection

