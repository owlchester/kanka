@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => route($entity->pluralType() . '.show', [$entity->entity_id]), 'label' => $entity->name],
        __('crud.actions.transform'),
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['entities.transform', $entity->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
        <div class="rounded shadow-xs bg-box p-4 max-w-3xl">
            <p class="help-block mb-2">
                {{ __('entities/transform.panel.description') }}
            </p>

            <a href="https://docs.kanka.io/en/latest/guides/transform.html" target="_blank" class="block mb-5">
                <i class="fa-solid fa-external-link" aria-hidden="true"></i>
                {{ __('crud.helpers.learn_more', ['documentation' => __('front.menu.documentation')]) }}
            </a>
            <div class="form-group">
                <label>{{ __('entities/transform.fields.target') }}</label>
                {!! Form::select('target', $entities, null, ['class' => 'form-control']) !!}
            </div>

            @includeWhen(!request()->ajax(), 'partials.footer_cancel')
            <button class="btn btn-success pull-right">
                <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
                {{ __('entities/transform.actions.transform') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
