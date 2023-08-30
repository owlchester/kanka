<?php /**
 * @var \App\Models\Bookmark $link
 */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('menu_links.reorder.title'),
    'description' => '',
    'breadcrumbs' => [
        __('menu_links.reorder.title')
    ],
    'mainTitle' => false,
    'bodyClass' => 'quick-links-reorder'
])


@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => ['quick-links.reorder-save', $campaign],
        'method' => 'POST',
    ]) !!}
    <h3 class="">
        {{ __('menu_links.reorder.title') }}
    </h3>
    <div class="box-entity-story-reorder max-w-4xl flex flex-col gap-5">
        <div class="element-live-reorder sortable-elements flex flex-col gap-2">
            @foreach($links as $link)
                <div class="element bg-base-200 rounded flex gap-2 p-2" data-id="{{ $link->id }}">
                    {!! Form::hidden('menu_link[]', $link->id) !!}
                    <div class="dragger pr-3">
                        <span class="fa-solid fa-ellipsis-v"></span>
                    </div>
                    <div class="name overflow-hidden flex-grow">
                        <i class="{{ $link->icon() }}"></i> {!! $link->name !!}
                    </div>
                    <div class="self-end">
                        @if ($link->is_private)
                            <i class="fa-solid fa-lock" data-title="{{ __('crud.is_private') }}"
                               data-toggle="tooltip"></i>
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
