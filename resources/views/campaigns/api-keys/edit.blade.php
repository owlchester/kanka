@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/api-keys.edit.title'),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('api-keys.index', $campaign), 'label' => trans('campaigns.show.tabs.api-keys')],
        $api-key->name,
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    <x-form :action="['api-keys.update', $campaign, $api-key->id]" method="PATCH">
        @include('partials.forms.form', [
            'title' => __('campaigns/api-keys.edit.title'),
            'content' => 'campaigns/api-keys._form',
            'submit' => __('crud.update'),
        ])
    </x-form>
@endsection
