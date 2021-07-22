@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        __('crud.tabs.attributes')
    ]
])

@section('content')
    @include('partials.errors')

    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>{{ __('entities/attributes.template.title', ['name' => $entity->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            {!! Form::open(['route' => ['entities.attributes.apply-template', $entity->id], 'method'=>'POST', 'data-shortcut' => '1']) !!}
            {{ csrf_field() }}
            <div class="form-group required">
                <label>{{ __('entities/attributes.fields.template') }}</label>
                {!! Form::select('template_id', \App\Models\AttributeTemplate::orderBy('name', 'ASC')->pluck('name', 'id'), null, ['placeholder' => __('entities/attributes.placeholders.template'), 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label>{{ __('entities/attributes.fields.community_templates') }}</label>
                {!! Form::select('template', $communityTemplates, null, ['placeholder' => __('entities/attributes.placeholders.template'), 'class' => 'form-control']) !!}
            </div>

            {!! Form::hidden('entity_id', $entity->id) !!}

            <div class="form-group">
                <button class="btn btn-success">{{ __('crud.actions.apply') }}</button>
                @includeWhen(!request()->ajax(), 'partials.or_cancel')
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection
