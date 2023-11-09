<?php /**
 * @var \App\Models\Bookmark $link
 */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('bookmarks.reorder.title'),
    'description' => '',
    'breadcrumbs' => [
        __('bookmarks.reorder.title')
    ],
    'mainTitle' => false,
    'bodyClass' => 'quick-links-reorder'
])


@section('content')
    {!! Form::open([
        'route' => ['bookmarks.reorder-save', $campaign],
        'method' => 'POST',
    ]) !!}
    <x-grid type="1/1">
        @include('partials.errors')

        <h3 class="">
            {{ __('bookmarks.reorder.title') }}
        </h3>

        <div class="box-entity-story-reorder max-w-4xl flex flex-col gap-5">
            <div class="element-live-reorder sortable-elements flex flex-col gap-2">
                @foreach($links as $link)
                    <div class="element bg-base-200 rounded flex gap-2 p-2" data-id="{{ $link->id }}">
                        {!! Form::hidden('bookmark[]', $link->id) !!}
                        <div class="dragger pr-3">
                            <span class="fa-solid fa-ellipsis-v" aria-hidden="true"></span>
                        </div>
                        <div class="name overflow-hidden grow">
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
        </div>
        <button class="btn2 btn-primary btn-block">
            {{ __('crud.save') }}
        </button>
    </x-grid>
    {!! Form::close() !!}
@endsection
