@extends('layouts.app', [
    'title' => trans('campaigns.members.edit.title', ['name' => $campaignUser->user->name]),
    'description' => trans('campaigns.members.edit.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.update'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($campaignUser, ['method' => 'PATCH', 'route' => ['campaign_user.update', $campaignUser->id]]) !!}
                    @include('campaigns.members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
