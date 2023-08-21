@extends('layouts.app', [
    'title' => __('tags.transfer.title', ['name' => $tag->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($tag->entity)->list(),
        Breadcrumb::show($tag),
        __('tags.transfer.transfer'),
    ]
])

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['tags.transfer', [$campaign, $tag->id]], 'method' => 'POST']) !!}

    {{ csrf_field() }}
    <div class="max-w-3xl">
        <x-box>
            <p class="help-block mb-5">
                {{ __('tags.transfer.description') }}
            </p>

            @include('cruds.fields.tag', ['model' => $tag, 'allowNew' => false])

            <x-dialog.footer>
                <button class="btn2 btn-primary">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    {{ __('tags.transfer.transfer') }}
                </button>
            </x-dialog.footer>
        </x-box>
    </div>

    {!! Form::close() !!}
@endsection
