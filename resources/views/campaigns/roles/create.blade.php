@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.roles.create.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index', $campaign), 'label' => __('campaigns.show.tabs.roles')],
        __('campaigns.roles.actions.add')
    ],
    'mainTitle' => false,
])

@section('content')
    {!! Form::open(['route' => ['campaign_roles.store', $campaign], 'method' => 'POST', 'data-shortcut' => 1, 'class' => 'entity-form']) !!}

    @include('partials.forms.form', [
            'title' => __('campaigns.roles.create.title'),
            'content' => 'campaigns.roles._form',
            'save' => __('campaigns.roles.actions.add')
        ])

    {!! Form::close() !!}
@endsection
