@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.relations.index', $entity->id), 'label' => __('crud.tabs.relations')],
    ]
])

@section('content')
    @if (request()->ajax())
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">
            {{ __('entities/relations.create.title', ['name' => $entity->name]) }}
        </h4>
    </div>
    <div class="modal-body">
    @else
    <div class="panel panel-default">
        <div class="panel-body">
    @endif

            @include('partials.errors')

            {!! Form::open(['route' => ['entities.relations.store', $entity->id], 'method' => 'POST', 'data-shortcut' => 1]) !!}
            @include('entities.pages.relations._form')

            {!! Form::hidden('entity_id', $entity->id) !!}
            {!! Form::hidden('owner_id', $entity->id) !!}

            <div class="form-group">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
                @includeWhen(!request()->ajax(), 'partials.or_cancel')
            </div>

            {!! Form::close() !!}

            @if(request()->ajax())
        </div>
        @else
        </div>
    </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ mix('js/relations.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/relations.css') }}" rel="stylesheet">
@endsection
