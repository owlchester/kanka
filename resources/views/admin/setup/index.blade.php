@extends('layouts.admin', [
    'title' => 'Setup',
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('admin.home'), 'label' => 'Setup']
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    {!! phpinfo() !!}
@endsection
