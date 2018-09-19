@extends('layouts.app', [
    'title' => trans('campaigns.show.title', ['name' => $campaign->name]),
    'description' => trans('campaigns.show.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')]
    ]
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu')
        </div>
        <div class="col-md-9">
            <div class="box box-flat">
                <div class="box-body">
                    <div class="post">
                        <p>{!! $campaign->entry !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
