@extends('layouts.admin', [
    'title' => 'Debug',
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('admin.home'), 'label' => 'Debug']
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    @dump($_SERVER)
    @dump(request()->headers)
@endsection
