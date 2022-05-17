@php
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.applications') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.applications')
    ],
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'submissions'])
        </div>
        <div class="col-md-9">
            <div class="box box-submissions">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        {{ __('campaigns.show.tabs.applications') }}
                    </h4>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-toggle="dialog"
                                data-target="submissions-help">
                            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                            {{ __('campaigns.members.actions.help') }}
                        </button>

                        <a href="#" data-url="{{ route('campaign-applications') }}" data-target="#small-modal" data-toggle="ajax-modal" class="btn btn-default btn-sm">
                            <i class="fa-solid fa-users-gear"></i>
                            {{ __('campaigns/submissions.actions.applications', ['status' => ($campaign->isOpen() ? __('campaigns/submissions.statuses.open') : __('campaigns/submissions.statuses.closed'))]) }}
                        </a>
                    </div>
                </div>
                @if (!$campaign->isOpen() || !$campaign->isPublic() || $submissions->isEmpty())
                <div class="box-body">
                    @if(!$campaign->isOpen())
                        <div class="callout callout-warning">
                            <p>{!! __('campaigns/submissions.helpers.not_open') !!}</p>
                            <p>
                                <button data-url="{{ route('campaign-applications') }}" data-target="#small-modal" data-toggle="ajax-modal" class="btn btn-warning">
                                    <i class="fa-solid fa-users-gear"></i>
                                    {{ __('campaigns/submissions.actions.change') }}
                                </button>
                            </p>
                        </div>
                    @else
                        @if(!$campaign->isPublic())
                            <div class="callout callout-warning">
                                <p>{{ __('campaigns/submissions.helpers.open_not_public') }}</p>
                                @if (auth()->user()->can('update', $campaign))
                                <a href="{{ route('campaigns.edit', [$campaign->id, '#tab_form-public']) }}" class="btn btn-warning">
                                    {{ __('crud.fix-this-issue') }}
                                </a>
                                @endif
                            </div>
                        @elseif ($submissions->isEmpty())
                            <div class="callout callout-info">
                                {!! __('campaigns/submissions.helpers.no_applications', ['button' => '<code><i class="fa-solid fa-door-open"></i> ' . __('dashboard.actions.join') . '</code>']) !!}
                            </div>
                        @endif
                    @endif
                </div>
                @endif
            </div>

            @include('campaigns.submissions._list')
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

    <div class="modal fade" id="small-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content rounded-2xl" id="small-modal-content"></div>
        </div>
    </div>
@endsection
