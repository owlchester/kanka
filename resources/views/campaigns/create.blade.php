@extends('layouts.app', [
    'title' => __('campaigns.create.title'),
    'breadcrumbs' => false,
    'skipBannerAd' => true,
    'startUI' => $start
])

@section('fullpage-form')
    {!! Form::open([
        'route' => 'create-campaign',
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
