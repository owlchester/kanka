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
    <x-form :action="['webhooks.update', $campaign, $webhook->id]" method="PATCH">
        @include('partials.forms.form', [
            'title' => __('campaigns/webhooks.edit.title'),
            'content' => 'campaigns/webhooks._form',
            'submit' => __('crud.update'),
        ])
    </x-form>
@endsection
