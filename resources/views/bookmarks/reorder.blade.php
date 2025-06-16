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
    'bodyClass' => 'bookmarks-reorder'
])


@section('content')
    <x-form :action="['bookmarks.reorder-save', $campaign]">
    <x-grid type="1/1">
        @include('partials.errors')

        <h3 class="">
            {{ __('bookmarks.reorder.title') }}
        </h3>

        <div class="box-entity-story-reorder max-w-4xl flex flex-col gap-5">
            <div class="element-live-reorder sortable-elements flex flex-col gap-2">
                @foreach($links as $link)
                    <x-reorder.child :id="$link->id">
                        <input type="hidden" name="bookmark[]" value="{{ $link->id }}" />
                        <div class="dragger">
                            <x-icon class="fa-regular fa-sort" />
                        </div>
                        <div class="grow flex items-center flex-no-wrap gap-2 overflow-hidden">
                            <i class="{{ $link->iconClass() }}" aria-hidden="true"></i>
                            <span class="truncate">
                                {!! $link->name !!}
                            </span>
                        </div>
                        <div class="self-end">
                            @if ($link->is_private)
                                <i class="fa-regular fa-lock" data-title="{{ __('crud.is_private') }}"
                                   data-toggle="tooltip"></i>
                            @endif
                        </div>
                    </x-reorder.child>
                @endforeach
            </div>
        </div>
        <button class="btn2 btn-primary btn-block">
            {{ __('crud.save') }}
        </button>
    </x-grid>
    </x-form>
@endsection
