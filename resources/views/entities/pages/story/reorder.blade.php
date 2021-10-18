<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote[]|\Illuminate\Support\Collection $notes
 * @var \App\Models\EntityNote $first
 */
$hasEntry = false;

$notes = $entity->notes()->ordered()->get();
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.reorder.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-story-reorder'
])
@inject('campaign', 'App\Services\CampaignService')



@include('entities.components.header', [
    'model' => $entity->child,
    'entity' => $entity,
    'breadcrumb' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
        __('entities/story.reorder.panel_title')
    ]
])
@section('content')
    @include('partials.errors')
    <div class="row entity-grid">
        <div class="col-md-2 entity-sidebar-submenu">
            @include($entity->pluralType() . '._menu', ['active' => 'story', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10 entity-main-block">

            {!! Form::open([
                'route' => ['entities.story.reorder-save', $entity],
                'method' => 'POST',
            ]) !!}
            <div class="box box-solid box-entity-story-reorder">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('entities/story.reorder.panel_title') }}
                    </h3>
                </div>
                <div class="box-body">


                    <div class="entity-notes-reorder">
                        @if ($notes->count() > 0)
                            @php $first = $notes->first(); @endphp
                            @if ($first->position >= 0)
                                @php $hasEntry = true @endphp
                                <div class="story" data-id="story">
                                    {!! Form::hidden('entity_types[]', 'story') !!}
                                    <div class="dragger">
                                        <span class="fa fa-ellipsis-v visible-md visible-lg"></span>
                                        <div class="visible-xs visible-sm">
                                            <span class="fa fa-arrow-up"></span><br />
                                            <span class="fa fa-arrow-down"></span>
                                        </div>
                                    </div>
                                    <div class="name">
                                        <i class="fas fa-align-justify"></i> {{ __('crud.fields.entry') }}
                                    </div>
                                    <div class="icons">
                                    </div>
                                </div>
                            @endif
                        @endif
                        @foreach($notes as $note)
                            @if (!$hasEntry && $note->position >= 0)
                                    @php $hasEntry = true @endphp
                                    <div class="story" data-id="story">
                                        {!! Form::hidden('entity_types[]', 'story') !!}
                                        <div class="dragger">
                                            <span class="fa fa-ellipsis-v visible-md visible-lg"></span>
                                            <div class="visible-xs visible-sm">
                                                <span class="fa fa-arrow-up"></span><br />
                                                <span class="fa fa-arrow-down"></span>
                                            </div>
                                        </div>
                                        <div class="name">
                                            <i class="fas fa-align-justify"></i> {{ __('crud.fields.entry') }}
                                        </div>
                                        <div class="icons">
                                        </div>
                                    </div>
                            @endif

                            <div class="story" data-id="{{ $note->id }}">
                                {!! Form::hidden('entity_note_id[]', $note->id) !!}
                                {!! Form::hidden('entity_types[]', 'post') !!}
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


                        @if (!$hasEntry)
                            @php $hasEntry = true @endphp
                            <div class="story" data-id="story">
                                {!! Form::hidden('entity_types[]', 'story') !!}
                                <div class="dragger">
                                    <span class="fa fa-ellipsis-v visible-md visible-lg"></span>
                                    <div class="visible-xs visible-sm">
                                        <span class="fa fa-arrow-up"></span><br />
                                        <span class="fa fa-arrow-down"></span>
                                    </div>
                                </div>
                                <div class="name">
                                    <i class="fas fa-align-justify"></i> {{ __('crud.fields.entry') }}
                                </div>
                                <div class="icons">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-block">
                        {{ __('entities/story.reorder.save') }}
                    </button>
                </div>
            </div>

            {!! Form::close() !!}
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
