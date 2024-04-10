@extends('layouts.app', [
    'title' => __('campaigns.create.title'),
    'breadcrumbs' => false,
    'skipBannerAd' => true,
    'startUI' => $start,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('fullpage-form')
    {!! Form::open([
        'route' => ['create-campaign'],
        'enctype' => 'multipart/form-data',
        'method' => 'POST',
        'data-shortcut' => '1',
        'class' => 'entity-form',
        'data-unload' => 1,
    'data-maintenance' => 1,
    ]) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.standard')
@endsection

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@include('editors.editor')

