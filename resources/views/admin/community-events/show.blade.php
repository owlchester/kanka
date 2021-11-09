<?php
/**
 * @var \App\Models\CommunityEvent $event
 * @var \App\Models\CommunityEventEntry[]|\Illuminate\Pagination\Paginator $entries
 */
?>
@extends('layouts.admin', [
    'title' => 'Community Event: ' . $event->name,
    'breadcrumbs' => [
        ['url' => route('admin.home'), 'label' => __('admin/home.title')],
        ['url' => route('admin.community-events.index'), 'label' => 'Community Events'],
        $event->name,
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="box box-solid">
        <div class="box-header with-border">

            <h4 class="box-title">{!! $event->name !!}</h4>
            <div class="box-tools">
                <a href="{{ route('community-events.show', $event) }}" class="btn btn-box-tool" title="View event" data-toggle="tooltip">
                    <i class="fa fa-external-link-alt"></i>
                </a>
                <a href="{{ route('admin.community-events.edit', $event) }}" class="btn btn-box-tool" title="Edit event" data-toggle="tooltip">
                    <i class="fa fa-pencil-alt"></i>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="text-muted">{{ $event->start_at->isoFormat('MMMM D, Y') }} - {{ $event->end_at->isoFormat('MMMM D, Y') }}</div>
            <div class="">
                {!! $event->entry !!}
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">

            <h4 class="box-title">Entries</h4>
        </div>
        <div class="box-body">
            <table class="table table-hover">
            <thead>
            <tr>
                <th>Rank</th>
                <th>User</th>
                <th>Discord</th>
                <th>Link</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <td>{{ $entry->rank }} <a data-toggle="collapse" href="#entry-id-{{ $entry->id }}" class="pull-right"><i class="fa fa-pencil-alt"></i></a></td>
                    <td>
                        {{ $entry->user->name }}
                    </td>
                    <td>
                        @if ($discord = $entry->user->apps->where('app', 'discord')->first())
                            <i class="fab fa-discord"></i> {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ $entry->link }}" target="_blank">{{ $entry->link }} <i class="fa fa-external-link-alt"></i></a>
                    </td>
                    <td>{!! nl2br($entry->comment) !!}</td>
                    <td>{{ $entry->created_at->diffForHumans() }} </td>
                </tr>
                <tr class="collapse out" id="entry-id-{{ $entry->id }}">
                    <td colspan="6">
                        <p class="text-muted">As soon as an entry has a rank, it will be shown on the results of the event's <a href="{{ route('community-events.show', $entry->event) }}" target="_blank">front page</a>.</p>
                        {!! Form::model($entry, ['route' => ['admin.community-entries.rank', $entry], 'method' => 'PUT', 'class' => 'form-inline']) !!}
                        <div class="form-group">
                            <label for="rank">Rank</label>
                            {!! Form::number('rank', null, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
        @if($entries->hasPages())
        <div class="box-footer text-right">
            {!! $entries->links() !!}
        </div>
        @endif
    </div>
@endsection
