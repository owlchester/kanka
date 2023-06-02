@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('campaigns/submissions.apply.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('dashboard.actions.join')
    ]
])


@section('content')
    {!! Form::open(['route' => ['campaign.apply.save'], 'method'=>'POST']) !!}
        <div class="modal-header">
            <x-dialog.close />
            <h4>{!! __('campaigns/submissions.apply.title', ['name' => $campaign->name]) !!}</h4>
        </div>

    <div class="modal-body">
        @include('partials.errors')

        <p class="help-block">{{ __('campaigns/submissions.apply.help') }}</p>

        <div class="form-group">
            <label>{{ __('campaigns/submissions.fields.application') }}</label>
            {!! Form::textarea('application', !empty($submission) ? $submission->text : null, [
                'class' => 'form-control', 'rows' => 5,
                'placeholder' => __('campaigns/submissions.placeholders.note')
            ]) !!}
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success">{{ empty($submission) ? __('campaigns/submissions.apply.apply') : __('crud.update') }}</button>
        @includeWhen(!request()->ajax(), 'partials.or_cancel')
        {!! Form::close() !!}

        @if($submission)
            <a role="button" tabindex="0" class="text-red-500 btn-dynamic-delete float-left" data-toggle="popover"
               title="{{ __('crud.delete_modal.title') }}"
               data-content="
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-submission'>{{ __('crud.remove') }}</a>">
                <x-icon class="trash"></x-icon> {{ __('crud.remove') }}
            </a>
        @endif
    </div>

    @if($submission)
        {!! Form::open(['method' => 'DELETE','route' => ['campaign.apply.remove'], 'style '=> 'display:inline', 'id' => 'delete-submission']) !!}
        {!! Form::close() !!}
        @endif
@endsection
