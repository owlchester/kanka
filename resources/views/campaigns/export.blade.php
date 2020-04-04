@extends('layouts.app', [
    'title' => trans('campaigns.export.title', ['name' => $campaign->name]),
    'description' => trans('campaigns.export.description'),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => $campaign->name],
        trans('campaigns.show.tabs.export')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3 col-lg-2">
            @include('campaigns._menu', ['active' => 'export'])
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="box box-solid">
                <div class="box-body">
                    @include('campaigns._export')
                </div>
            </div>
        </div>
    </div>
@endsection
