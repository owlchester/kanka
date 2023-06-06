@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.update.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.story'),
        __('crud.edit')
    ],
    'mainTitle' => false,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')

    {!! Form::model($entity->child, ['route' => ['entities.entry.update', $entity], 'method' => 'PATCH', 'data-shortcut' => 1, 'class' => 'entity-form entity-entry-form', 'data-maintenance' => 1, 'data-unload' => 1,]) !!}

        @include('partials.errors')


        <div class="form-group">
            {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
        </div>

        <div class="">
            <div class="pull-right">
                <button class="btn2 btn-primary" id="form-submit-main">{{ __('crud.update') }}</button>
            </div>
            <a href="{{ url()->previous() }}" class="btn2 btn-ghost">
                {{ __('crud.cancel') }}
            </a>
        </div>

    {!! Form::close() !!}

    {{-- For bragi --}}
    @if ($entity->isCharacter())
        <input type="hidden" name="name" value="{{ $entity->name }}" />
    @endif
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])
