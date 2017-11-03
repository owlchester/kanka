@extends('layouts.app', [
    'title' => trans('search.title'),
    'description' => trans('search.description'),
    'breadcrumbs' => [
        trans('search.title'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Search</h3>
                </div>
                {!! Form::open(array('route' => 'search', 'method'=>'GET')) !!}
                <div class="box-body">
                    <div class="form-group">
                <!-- form start -->
                        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request()->get('q') }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="pull-right btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#characters" data-toggle="tab" aria-expanded="false">Characters
                        <span class="badge bg-blue">{{ count($characters) }}</span></a>
                    </li>
                    <li class=""><a href="#locations" data-toggle="tab" aria-expanded="false">Locations
                        <span class="badge bg-blue">{{ count($locations) }}</span></a>
                    </li>
                    <li class=""><a href="#items" data-toggle="tab" aria-expanded="false">Items
                        <span class="badge bg-blue">{{ count($items) }}</span></a>
                    </li>
                    <li class=""><a href="#organisations" data-toggle="tab" aria-expanded="false">Organisations
                        <span class="badge bg-blue">{{ count($organisations) }}</span></a>
                    </li>
                    <li class=""><a href="#notes" data-toggle="tab" aria-expanded="false">Notes
                        <span class="badge bg-blue">{{ count($notes) }}</span></a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="characters">
                        @include('characters.datagrid', ['models' => $characters])
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'locations' ? ' active' : '') }}" id="locations">
                        @include('locations.datagrid', ['models' => $locations])
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'items' ? ' active' : '') }}" id="items">
                        @include('items.datagrid', ['models' => $items])
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'organisations' ? ' active' : '') }}" id="organisations">
                        @include('organisations.datagrid', ['models' => $organisations])
                    </div>
                    <div class="tab-pane {{ (request()->get('tab') == 'notes' ? ' active' : '') }}" id="notes">
                        @include('notes.datagrid', ['models' => $notes])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection