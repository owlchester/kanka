@extends('layouts.app', [
    'title' => trans('campaigns.roles.title', ['name' => $campaign->name]),
    'description' => trans('campaigns.roles.description'),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => $campaign->name],
        trans('campaigns.show.tabs.roles')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'roles'])
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                @include('campaigns._roles')
            </div>
        </div>
    </div>
@endsection
