@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('campaigns/submissions.apply.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('dashboard.actions.join')
    ]
])


@section('content')

    <x-dialog.header>
        {!! __('campaigns/submissions.apply.title', ['name' => $campaign->name]) !!}
    </x-dialog.header>
    <article>
        {!! Form::open(['route' => ['campaign.apply.save', $campaign], 'method'=>'POST', 'class' => 'max-w-xl']) !!}

        @include('partials.errors')

        <p class="help-block">{{ __('campaigns/submissions.apply.help') }}</p>

        <div class="field-group">
            <label>{{ __('campaigns/submissions.fields.application') }}</label>
            {!! Form::textarea('application', !empty($submission) ? $submission->text : null, [
                'class' => 'form-control', 'rows' => 5,
                'placeholder' => __('campaigns/submissions.placeholders.note')
            ]) !!}
        </div>


        <x-dialog.footer>

            @if($submission)
                <x-button.delete-confirm target="#delete-submission" />
            @endif

            <x-buttons.confirm type="primary">
                <x-icon class="save"></x-icon>
                {{ empty($submission) ? __('campaigns/submissions.apply.apply') : __('crud.update') }}
            </x-buttons.confirm>
        </x-dialog.footer>
        {!! Form::close() !!}

        @if($submission)
            {!! Form::open(['method' => 'DELETE','route' => ['campaign.apply.remove', $campaign], 'style '=> 'display:inline', 'id' => 'delete-submission']) !!}
            {!! Form::close() !!}
        @endif
    </article>
@endsection
