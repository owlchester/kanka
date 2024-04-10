@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/webhooks.edit.title'),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('webhooks.index', $campaign), 'label' => trans('campaigns.show.tabs.webhooks')],
        $webhook->name,
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    {!! Form::model($webhook, ['method' => 'PATCH', 'route' => ['webhooks.toggle', $campaign, $webhook->id], 'data-shortcut' => 1, 'class' => 'entity-form']) !!}

    @include('partials.forms.form', [
            'title' => __('campaigns/webhooks.edit.title'),
            'content' => 'campaigns/webhooks._status',
            'submit' => __('campaigns/webhooks.actions.update'),
            'dialog' => true,
        ])
    {!! Form::close() !!}
@endsection
