@extends('layouts.app', [
    'title' => trans('helpers.title'),
    'breadcrumbs' => [
        trans('helpers.link.title')
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4>{{ trans('helpers.dice.title') }}</h4>
                </div>

                <div class="box-body">
                    <p>{{ trans('helpers.dice.description') }}</p>
                    <p>{{ trans('helpers.dice.description_attributes') }}</p>
                    <p><a href="https://github.com/ringmaster/dicecalc#Dice" target="_blank">{{ trans('helpers.dice.more') }}</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
