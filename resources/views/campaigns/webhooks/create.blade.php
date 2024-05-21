@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/webhooks.create.title'),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('webhooks.index', $campaign), 'label' => __('campaigns.show.tabs.webhooks')],
        __('campaigns/webhooks.actions.add')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    {!! Form::open(['route' => ['webhooks.store', $campaign], 'method' => 'POST', 'data-shortcut' => 1, 'class' => 'ajax-subform']) !!}

    @include('partials.forms.form', [
            'title' => __('campaigns/webhooks.create.title'),
            'content' => 'campaigns/webhooks._form',
            'save' => __('campaigns/webhooks.actions.add'),
            'dialog' => true,
        ])

    {!! Form::close() !!}
@endsection
