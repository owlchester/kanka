@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/api-keys.create.title'),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('api-keys.index', $campaign), 'label' => __('campaigns.show.tabs.api-keys')],
        __('campaigns/api-keys.actions.add')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    <x-form :action="['api-keys.store', $campaign]">
        @include('partials.forms.form', [
            'title' => __('campaigns/api-keys.create.title'),
            'content' => 'campaigns/api-keys._form',
            'save' => __('campaigns/api-keys.actions.add'),
        ])
    </x-form>
@endsection
