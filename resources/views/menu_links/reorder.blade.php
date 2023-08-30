<?php /**
 * @var \App\Models\MenuLink $link */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('menu_links.reorder.title'),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        __('menu_links.reorder.title')
    ],
    'mainTitle' => false,
    'bodyClass' => 'quick-links-reorder'
])


@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => 'quick-links.reorder-save',
        'method' => 'POST',
    ]) !!}
    <h3 class="">
        {{ __('menu_links.reorder.title') }}
    </h3>
    <div class="box-entity-story-reorder max-w-4xl">
        <div class="element-live-reorder sortable-elements flex flex-col gap-1">
            @foreach($links as $link)
                <div class="element bg-base-200" data-id="{{ $link->id }}">
                    {!! Form::hidden('menu_link[]', $link->id) !!}
                    <div class="dragger pr-3">
                        <span class="fa-solid fa-ellipsis-v"></span>
                    </div>
                    <div class="name overflow-hidden flex-grow">
                        <i class="{{ $link->icon() }}"></i> {!! $link->name !!}
                    </div>
                    <div class="self-end">
                        @if ($link->is_private)
                            <i class="fa-solid fa-lock" data-title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn2 btn-primary btn-block">
            {{ __('crud.save') }}
        </button>
    </div>
    {!! Form::close() !!}
@endsection
