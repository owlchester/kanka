@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __($name . '.create.title'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $name)],
        __('crud.create'),
    ]
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    <x-cta :campaign="$campaign" image="0">
        <p>{{ __('campaigns/limits.' . $key) }}</p>
    </x-cta>
@endsection
