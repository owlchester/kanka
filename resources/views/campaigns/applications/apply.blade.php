@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/applications.apply.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('dashboard.actions.join')
    ]
])

@section('content')
    <x-form :action="['campaign.apply.save', $campaign]" class="max-w-xl">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/applications.apply.title', ['name' => $campaign->name]),
        'content' => 'campaigns.applications._apply',
        'save' => empty($application) ? __('campaigns/applications.apply.apply') : __('crud.update'),
        'deleteID' =>  $application ? '#delete-application' : null,
    ])
    </x-form>

    @if($application)
        <x-form method="DELETE" :action="['campaign.apply.remove', $campaign]" id="delete-application" />
    @endif
@endsection
