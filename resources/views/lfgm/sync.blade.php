@extends('layouts.minimal', [
    'title' => __('lfgm.sync.title')
])
@php
$cpt = 0;
@endphp

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-solid">
                <div class="box-body">

                    <h2 class="page-header with-border">
                        {{ __('lfgm.sync.title') }}
                    </h2>

                    <p class="help-block">
                        {!! __('lfgm.sync.helper', ['lfgm' => link_to('https://lookingforgm.com', 'LookingForGM')]) !!}
                    </p>

                    @include('partials.errors')

                    {!! Form::open(['route' => ['lfgm.syncSave', 'uuid' => $uuid], 'method' => 'POST']) !!}
                    <div class="row">
                        @foreach ($campaigns as $campaign)
@if($cpt++ % 3 === 0)
                    </div><div class="row">
@endif
                            <div class="col-md-4 margin-bottom">
                                <div class="campaign clickable" data-campaign="{{ $campaign->id }}" @if ($campaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($campaign->image) }}');" @endif>
                                    <div class="actions">
                                        <span>{!! $campaign->name !!}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="uuid" value="{{ $uuid }}" />
                    <input type="hidden" name="campaign" />

                    <div class="text-center">
                        <input type="submit" class="btn btn-lg btn-primary" disabled value="{{ __('lfgm.sync.actions.sync') }}" />
                    </div>

                    {{ csrf_field() }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="{{ mix('css/settings.css') }}" rel="stylesheet">
@endsection


@section('scripts')
    <script src="{{ mix('js/lfgm.js') }}" defer></script>
@endsection
