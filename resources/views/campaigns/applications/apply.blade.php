@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns/applications.apply.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('dashboard.actions.join')
    ]
])

@section('content')
    <x-dialog.header>
        {{ __('campaigns/applications.apply.title', ['name' => $campaign->name]) }}
    </x-dialog.header>
    <x-form :action="['campaign.apply.save', $campaign]">
        <x-dialog.article>
            @include('partials.errors')
            @include('campaigns.applications._apply')
        </x-dialog.article>

        <x-dialog.footer>
            @if($application)
                <x-slot:cancel>
                    <x-button.delete-confirm target="#delete-application" />
                </x-slot:cancel>
            @endif

            <button type="submit" class="btn2 btn-primary">
                {{ empty($application) ? __('campaigns/applications.apply.apply') : __('crud.update') }}
            </button>
        </x-dialog.footer>
    </x-form>

    @if($application)
        <x-form method="DELETE" :action="['campaign.apply.remove', $campaign]" id="delete-application" />
    @endif
@endsection
