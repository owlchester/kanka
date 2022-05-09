<?php /**
 * @var \App\Models\MenuLink $link */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('menu_links.reorder.title'),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('menu_links'), 'label' => __('menu_links.index.title')],
        __('menu_links.reorder.title')
    ],
    'mainTitle' => false,
    'bodyClass' => 'quick-links-reorder'
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')

    {!! Form::open([
        'route' => 'quick-links.reorder-save',
        'method' => 'POST',
    ]) !!}
    <div class="box box-solid box-entity-story-reorder">
        <div class="box-header">
            <h3 class="box-title">
                {{ __('menu_links.reorder.title') }}
            </h3>
        </div>
        <div class="box-body">
            <div class="element-live-reorder">
                @foreach($links as $link)
                    <div class="element" data-id="{{ $link->id }}">
                        {!! Form::hidden('menu_link[]', $link->id) !!}
                        <div class="dragger">
                            <span class="fa-solid fa-ellipsis-v visible-md visible-lg"></span>
                            <div class="visible-xs visible-sm">
                                <span class="fa-solid fa-arrow-up"></span><br />
                                <span class="fa-solid fa-arrow-down"></span>
                            </div>
                        </div>
                        <div class="name">
                            <i class="{{ $link->icon() }}"></i> {!! $link->name !!}
                        </div>
                        <div class="icons">
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



@section('styles')
    @parent
    <link href="{{ mix('css/story.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/story.js') }}" defer></script>
@endsection
