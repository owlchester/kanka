<?php /**
 * @var \App\Models\MenuLink $link */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('menu_links.reorder.title'),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('menu_links'), 'label' => __('entities.menu_links')],
        __('menu_links.reorder.title')
    ],
    'mainTitle' => false,
    'bodyClass' => 'quick-links-reorder'
])



@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => ['quick-links.reorder-save', [$campaign]],
        'method' => 'POST',
    ]) !!}
    <div class="box box-solid box-entity-story-reorder">
        <div class="box-header">
            <h3 class="box-title">
                {{ __('menu_links.reorder.title') }}
            </h3>
        </div>
        <div class="box-body">
            <div class="element-live-reorder sortable-elements">
                @foreach($links as $link)
                    <div class="element" data-id="{{ $link->id }}">
                        {!! Form::hidden('menu_link[]', $link->id) !!}
                        <div class="dragger pr-3">
                            <span class="fa-solid fa-ellipsis-v"></span>
                        </div>
                        <div class="name overflow-hidden flex-grow">
                            <i class="{{ $link->icon() }}"></i> {!! $link->name !!}
                        </div>
                        <div class="self-end">
                            @if ($link->is_private)
                                <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box-footer">

            <button class="btn btn-primary btn-block">
                {{ __('crud.save') }}
            </button>

        </div>
    </div>
    {!! Form::close() !!}
@endsection
