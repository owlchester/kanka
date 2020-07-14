@extends('layouts.app', [
    'title' => trans('campaigns.create.title'),
    'breadcrumbs' => $start ? false : [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.create')
    ],
])

@section('fullpage-form')
    {!! Form::open([
        'route' => ($start ? 'start' : 'campaigns.store'),
        'enctype' => 'multipart/form-data',
        'method' => 'POST',
        'data-shortcut' => '1',
        'class' => 'entity-form',
    ]) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))
@endsection

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@include('editors.editor')

@section('scripts')
    @parent
    <script src="{{ mix('js/campaign.js') }}" defer></script>
@endsection
