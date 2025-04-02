@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.roles.create.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index', $campaign), 'label' => __('campaigns.show.tabs.roles')],
        __('campaigns.roles.actions.add')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    <x-form :action="['campaign_roles.store', $campaign]">

    @include('partials.forms._dialog', [
            'title' => __('campaigns.roles.create.title'),
            'content' => 'campaigns.roles._form',
            'submit' => __('crud.create'),
            'model' => null,
        ])

    </x-form>
@endsection
