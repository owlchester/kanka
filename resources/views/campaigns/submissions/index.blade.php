@php
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.applications') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.applications')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'submissions'])
        </div>
        <div class="grow max-w-7xl">
            <div class="flex gap-2 mb-5 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.applications') }}
                </h3>
                <button class="btn btn-sm btn-default" data-toggle="dialog"
                        data-target="submissions-help">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    {{ __('campaigns.members.actions.help') }}
                </button>

                <a href="#" data-url="{{ route('campaign-applications') }}" data-target="submission-dialog" data-toggle="dialog-ajax" class="btn btn-default btn-sm">
                    <i class="fa-solid fa-users-gear" aria-hidden="true"></i>
                    {{ __('campaigns/submissions.actions.applications', ['status' => ($campaign->isOpen() ? __('campaigns/submissions.statuses.open') : __('campaigns/submissions.statuses.closed'))]) }}
                </a>
            </div>

            @if (!$campaign->isOpen() || !$campaign->isPublic() || $submissions->isEmpty())
                @if(!$campaign->isOpen())
                    <div class="alert alert-warning">
                        <p>{!! __('campaigns/submissions.helpers.not_open') !!}</p>
                        <p>
                            <button data-url="{{ route('campaign-applications') }}" data-target="ajax-dialog" data-toggle="dialog-ajax" class="btn btn-warning">
                                <i class="fa-solid fa-users-gear" aria-hidden="true"></i>
                                {{ __('campaigns/submissions.actions.change') }}
                            </button>
                        </p>
                    </div>
                @else
                    @if(!$campaign->isPublic())
                        <div class="alert alert-warning">
                            <p>{{ __('campaigns/submissions.helpers.open_not_public') }}</p>
                            @if (auth()->user()->can('update', $campaign))
                            <a href="{{ route('campaigns.edit', ['#tab_form-public']) }}" class="btn btn-warning">
                                {{ __('crud.fix-this-issue') }}
                            </a>
                            @endif
                        </div>
                    @elseif ($submissions->isEmpty())
                        <div class="alert alert-info">
                            {!! __('campaigns/submissions.helpers.no_applications', ['button' => '<code><i class="fa-solid fa-door-open" aria-hidden="true"></i> ' . __('dashboard.actions.join') . '</code>']) !!}
                        </div>
                    @endif
                @endif
            @endif

            @includeWhen(!$submissions->isEmpty(), 'campaigns.submissions._list')
        </div>
    </div>
@endsection


@section('modals')

    @include('partials.helper-modal', [
        'id' => 'submissions-help',
        'title' => __('campaigns.show.tabs.applications'),
        'textes' => [
            __('campaigns/submissions.helpers.modal')
    ]])

    <x-dialog id="submission-dialog" title="{{ __('Loading') }}">
        <div class="p-5 text-center">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
        </div>
    </x-dialog>
@endsection
