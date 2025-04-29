@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/default-images.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign.default-images', $campaign), 'label' => trans('campaigns/default-images.index.title')]
    ]
])

@section('content')

    <x-form :action="['campaign.default-images.store', $campaign]" files>
    @include('partials.forms.form', [
        'title' => __('campaigns/default-images.create.title', ['name' => $campaign->name]),
        'content' => 'campaigns.default-images._form',
    ])
    </x-form>
@endsection
