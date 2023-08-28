@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('campaigns/submissions.apply.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('dashboard.actions.join')
    ]
])

@section('content')
    {!! Form::open(['route' => ['campaign.apply.save', $campaign], 'method'=>'POST', 'class' => 'max-w-xl']) !!}
    @include('partials.forms.form', [
        'title' => __('campaigns/submissions.apply.title', ['name' => $campaign->name]),
        'content' => 'campaigns.submissions._apply',
        'save' => empty($submission) ? __('campaigns/submissions.apply.apply') : __('crud.update'),
        'deleteID' =>  $submission ? '#delete-submission' : null,
        'dialog' => true,
    ])
    {!! Form::close() !!}

    @if($submission)
        {!! Form::open(['method' => 'DELETE','route' => ['campaign.apply.remove', $campaign], 'style '=> 'display:inline', 'id' => 'delete-submission']) !!}
        {!! Form::close() !!}
    @endif
@endsection
