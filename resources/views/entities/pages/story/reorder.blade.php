<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.reorder.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities/story.reorder.panel_title')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-story-reorder'
])
@inject('campaign', 'App\Services\CampaignService')


@include('entities.components.header', ['model' => $entity->child, 'entity' => $entity])

@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include($entity->pluralType() . '._menu', ['active' => 'story', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10 entity-main-block">
            <div class="box box-solid box-entity-story-reorder">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('entities/story.reorder.panel_title') }}
                    </h2>

                    {!! Form::open([
                        'route' => ['entities.story.reorder-save', $entity],
                        'method' => 'POST',
                    ]) !!}

                    <div class="entity-notes-reorder">
                        @foreach($entity->notes()->ordered()->get() as $note)
                            <div class="story" data-id="{{ $note->id }}">
                                {!! Form::hidden('entity_note_id[]', $note->id) !!}
                                <div class="dragger">
                                    <span class="fa fa-ellipsis-v visible-md visible-lg"></span>
                                    <div class="visible-xs visible-sm">
                                        <span class="fa fa-arrow-up"></span><br />
                                        <span class="fa fa-arrow-down"></span>
                                    </div>
                                </div>
                                <div class="name">
                                    {!! $note->name !!}
                                </div>
                                <div class="icons">
                                    @include('cruds.partials.visibility', ['model' => $note])
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
