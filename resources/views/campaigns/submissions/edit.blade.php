<?php /** @var \App\Models\CampaignSubmission $submission */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/submissions.edit.title', ['name' => $submission->user->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_submissions.index'), 'label' => __('campaigns.show.tabs.applications')],
        $submission->user->name,
    ],
    'mainTitle' => false,
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($submission, ['method' => 'PATCH', 'route' => ['campaign_submissions.update', $submission->id], 'data-shortcut' => 1, 'class' => 'entity-form']) !!}

            @if($action === 'approve')
                <p>{{ __('campaigns/submissions.update.approve') }}</p>
                <div class="form-group">
                    <label>{{ __('campaigns.members.fields.role') }}</label>
                    {!! Form::select('role_id', $campaign->roles()->where('is_public', false)->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>

                <input type="submit" class="btn btn-primary" value="{{ __('campaigns/submissions.actions.accept') }}" />
            @else
                <p>{{ __('campaigns/submissions.update.reject') }}</p>
                <div class="form-group">
                    <label>{{ __('campaigns/submissions.fields.rejection') }}</label>
                    {!! Form::text('rejection', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
                </div>

                <input type="submit" class="btn btn-danger" value="{{ __('campaigns/submissions.actions.reject') }}" />
            @endif

            <input type="hidden" name="action" value="{{ $action }}" />
            {!! Form::close() !!}
        </div>
    </div>
@endsection
