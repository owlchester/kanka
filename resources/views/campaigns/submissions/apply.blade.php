@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('campaigns/submissions.apply.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('dashboard.actions.join')
    ]
])


@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{!! __('campaigns/submissions.apply.title', ['name' => $campaign->name]) !!}</h4>
            </div>
        @endif
        {!! Form::open(['route' => ['campaign.apply.save'], 'method'=>'POST']) !!}
        <div class="panel-body">
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
        <div class="panel-footer">
            <button class="btn btn-success">{{ empty($submission) ? __('campaigns/submissions.apply.apply') : __('crud.update') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
            {!! Form::close() !!}

            @if($submission)
                <a href="#" class="btn btn-default text-danger delete-confirm pull-right"
                   data-toggle="modal" data-target="#delete-confirm" data-delete-target="delete-submission" data-name="{{ __('campaigns/submissions.apply.remove_text') }}">
                    <i class="fa fa-trash-o"></i> {{ __('crud.remove') }}
                </a>

                {!! Form::open(['method' => 'DELETE','route' => ['campaign.apply.remove'], 'style '=> 'display:inline', 'id' => 'delete-submission']) !!}
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@endsection
