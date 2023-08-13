@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.actions.transform'),
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['entities.transform', $campaign, $entity->id], 'method' => 'POST']) !!}

    {{ csrf_field() }}
        <div class="max-w-3xl">
            <x-box>
                <p class="help-block mb-2">
                    {{ __('entities/transform.panel.description') }}
                </p>

                <a href="https://docs.kanka.io/en/latest/guides/transform.html" target="_blank" class="block mb-5">
                    <i class="fa-solid fa-external-link" aria-hidden="true"></i>
                    {{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}
                </a>
                <div class="field-target">
                    <label>{{ __('entities/transform.fields.target') }}</label>
                    {!! Form::select('target', $entities, null, ['class' => 'form-control']) !!}
                </div>

                <x-dialog.footer>
                    <button class="btn2 btn-primary">
                        <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
                        {{ __('entities/transform.actions.transform') }}
                    </button>
                </x-dialog.footer>
            </x-box>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
