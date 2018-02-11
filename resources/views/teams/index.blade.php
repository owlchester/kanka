@extends('layouts.app', [
    'title' => trans('teams.index.title'),
    'description' => trans('teams.index.description'),
])

@section('content')
    <h1>{{ trans('teams.index.core') }}</h1>
<div class="row">
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Ilestis</h3>
            </div>
            <div class="box-body">
                Lead
            </div>
        </div>
    </div>
</div>

<h1>{{ trans('teams.index.translations') }}</h1>
<div class="row">
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('languages.codes.de') }}</h3>
            </div>
            <div class="box-body">
                <p>TheFurya</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('languages.codes.en-US') }}</h3>
            </div>
            <div class="box-body">
                <p>Oriek</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('languages.codes.es') }}</h3>
            </div>
            <div class="box-body">
                <p>Raigho</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('languages.codes.fr') }}</h3>
            </div>
            <div class="box-body">
                <p>Ilestis</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('languages.codes.pt-BR') }}</h3>
            </div>
            <div class="box-body">
                <p>Republik</p>
            </div>
        </div>
    </div>
</div>

@endsection