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
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-entity-story-reorder">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('menu_links.reorder.title') }}
                    </h2>

                    {!! Form::open([
                        'route' => 'quick-links.reorder-save',
                        'method' => 'POST',
                    ]) !!}

                    <div class="entity-notes-reorder">
                        @foreach($links as $link)
                            <div class="story" data-id="{{ $link->id }}">
                                {!! Form::hidden('menu_link[]', $link->id) !!}
                                <div class="dragger">
                                    <span class="fa fa-ellipsis-v visible-md visible-lg"></span>
                                    <div class="visible-xs visible-sm">
                                        <span class="fa fa-arrow-up"></span><br />
                                        <span class="fa fa-arrow-down"></span>
                                    </div>
                                </div>
                                <div class="name">
                                    <i class="{{ $link->icon() }}"></i> {!! $link->name !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button class="btn btn-primary btn-block">
                        {{ __('crud.save') }}
                    </button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection



@section('styles')
    @parent
    <link href="{{ mix('css/story.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/story.js') }}" defer></script>
@endsection
