@extends('layouts.app', [
    'title' => __('tags.transfer.title', ['name' => $tag->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($tag->entity->pluralType()), 'label' => \App\Facades\Module::plural($tag->entity->typeId(), __('entities.' . $tag->entity->pluralType()))],
        ['url' => route($tag->entity->pluralType() . '.show', [$tag->entity->entity_id]), 'label' => $tag->name],
        __('tags.transfer.transfer'),
    ]
])
@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    {!! Form::open(['route' => ['tags.transfer', $tag->id], 'method' => 'POST']) !!}

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
