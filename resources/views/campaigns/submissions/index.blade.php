@php
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.applications') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.applications')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('ads.top')
    @include('partials.errors')

    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.applications') }}
            </h3>
            <button class="btn2 btn-sm btn-ghost" data-toggle="dialog"
                    data-target="submissions-help">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </button>

            <a href="#" data-url="{{ route('campaign-applications', $campaign) }}" data-target="submission-dialog" data-toggle="dialog-ajax" class="btn2 btn-sm">
                <x-icon class="fa-solid fa-users-gear" />
                {{ __('campaigns/submissions.actions.applications', ['status' => ($campaign->isOpen() ? __('campaigns/submissions.statuses.open') : __('campaigns/submissions.statuses.closed'))]) }}
            </a>
        </div>

        @if (!$campaign->isOpen() || !$campaign->isPublic() || $submissions->isEmpty())
            @if(!$campaign->isOpen())
                <x-alert type="warning">
                    <p>{!! __('campaigns/submissions.helpers.not_open') !!}</p>
                    <p>
                        <button data-url="{{ route('campaign-applications', $campaign) }}" data-target="submission-dialog" data-toggle="dialog-ajax" class="btn2 btn-outline">
                            <x-icon class="fa-solid fa-users-gear" />
                            {{ __('campaigns/submissions.actions.change') }}
                        </button>
                    </p>
                </x-alert>
            @else
                @if(!$campaign->isPublic())
                    <x-alert type="warning">
                        <p>{{ __('campaigns/submissions.helpers.open_not_public') }}</p>
                        @if (auth()->user()->can('update', $campaign))
                        <a href="{{ route('campaigns.edit', [$campaign, '#tab_form-public']) }}" class="btn2">
                            {{ __('crud.fix-this-issue') }}
                        </a>
                        @endif
                    </x-alert>
                @elseif ($submissions->isEmpty())
                    <x-alert type="info">
                        <p>{!! __('campaigns/submissions.helpers.no_applications', ['button' => '<code><i class="fa-solid fa-door-open" aria-hidden="true"></i> ' . __('dashboard.actions.join') . '</code>']) !!}</p>
                    </x-alert>
                @endif
            @endif
        @endif

        @includeWhen(!$submissions->isEmpty(), 'campaigns.submissions._list')
    </div>
@endsection


@section('modals')

    @include('partials.helper-modal', [
        'id' => 'submissions-help',
        'title' => __('campaigns.show.tabs.applications'),
        'textes' => [
            __('campaigns/submissions.helpers.modal')
    ]])

    <x-dialog id="submission-dialog" loading="true" />
@endsection
