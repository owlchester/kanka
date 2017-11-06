@extends('layouts.app', ['title' => trans('campaigns.members.edit.title'), 'description' => trans('campaigns.members.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('campaigns.members.edit.title', ['name' => $member->user->name) }}</div>

                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($member, ['method' => 'PATCH', 'route' => ['campaign_member.update', $member->id]]) !!}
                    @include('campaigns.members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
