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
    <x-form :action="['webhooks.store', $campaign]">
        @include('partials.forms.form', [
            'title' => __('campaigns/webhooks.create.title'),
            'content' => 'campaigns/webhooks._form',
            'save' => __('campaigns/webhooks.actions.add'),
        ])
    </x-form>
@endsection
