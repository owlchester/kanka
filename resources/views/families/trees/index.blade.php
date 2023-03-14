@extends('layouts.app', [
    'title' => __('families/trees.title', ['name' => $family->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $family,
])

@if ($mode === 'pixi')
@section('entity-header-actions')
    @can('update', $family)
        <div class="flex w-full">
            <div class="grow text-right">
                <a href="#" class="btn btn-sm btn-warning" id="tree-edit">
                    <i class="fa-solid fa-edit" aria-hidden="true"></i> {{ __('crud.edit') }}
                </a>
                <a href="#" class="btn btn-sm btn-primary mr-1" id="first-entity" style="display: none">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('families/trees.actions.first') }}
                </a>
                <a href="#" class="btn btn-sm btn-default" id="tree-reset" style="display: none">
                    <i class="fa-solid fa-redo" aria-hidden="true"></i>
                    {{ __('families/trees.actions.reset') }}
                </a>
                <a href="#" class="btn btn-sm btn-default" id="tree-clear" style="display: none">
                    <i class="fa-solid fa-eraser" aria-hidden="true"></i>
                    {{ __('families/trees.actions.clear') }}
                </a>
                <a href="#" class="btn btn-sm btn-primary" id="tree-save" style="display: none">
                    <i class="fa-solid fa-save" aria-hidden="true"></i>
                    {{ __('families/trees.actions.save') }}
                </a>
            </div>
        </div>
    @endcan
@endsection
@endif


@inject('campaignService', 'App\Services\CampaignService')

@section('content')
<div id="clear" data-desc="{{ __('families/trees.helpers.clear') }}" data-text="xzy"></div>
<div id="reset" data-desc="{{ __('families/trees.helpers.reset') }}" data-text="xzy"></div>
<div id="relation" data-desc="{{ __('families/trees.helpers.relation') }}" data-text="xzy"></div>
<div id="saved" data-desc="{{ __('families/trees.saved') }}" data-text="xzy"></div>
<div id="rename" data-desc="{{ __('families/trees.actions.rename-relation') }}" data-text="xzy"></div>
<div id="remove" data-desc="{{ __('families/trees.helpers.remove-node') }}" data-text="xzy"></div>
<div id="unknown" data-desc="{{ __('families/trees.unknown') }}" data-text="xzy"></div>

    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $family,
            'breadcrumb' => [
                ['url' => Breadcrumb::index('families'), 'label' => __('entities.families')],
                null
            ]
        ])

        @include('families._menu', ['active' => 'tree', 'model' => $family])

        <div class="entity-main-block">

            @if (!$campaign->superboosted())
                @include('layouts.callouts.boost', ['texts' => [
            __('families/trees.pitch')], 'superboost' => true])
            @else
                @if ($mode === 'pixi')
                <div class="family-tree-setup overflow-x overflow-y"
                    data-api="{{ route('families.family-tree.api', $family) }}"
                    data-save="{{ route('families.family-tree.api-save', $family) }}"
                    data-entity="{{ route('families.family-tree.entity-api', 0) }}"
                >
                </div>
                @else
                <div id="family-tree">
                    <family-tree
                        api="{{ route('families.family-tree.api', $family) }}"
                        save_api="{{ route('families.family-tree.api-save', $family) }}"
                        entity_api="{{ route('families.family-tree.entity-api', 0) }}"
                        search_api="{{ route('search.entities-with-relations', ['only' => config('entities.ids.character')]) }}"
                    >
                    </family-tree>
                </div>
                @endif
            @endif
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    @if ($mode === 'pixi')
        <script src="{{ mix('js/family-tree.js') }}" defer></script>
    @else
        <script src="{{ mix('js/family-tree-vue.js') }}" defer></script>
    @endif
@endsection
@section('styles')
    @parent
    @if ($mode === 'vue')
        <link href="{{ mix('css/family-tree.css') }}" rel="stylesheet">
    @endif
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="add-entity" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle">
                        {{ __('families/trees.modal.title') }}
                    </h4>
                    <h4 class="modal-title" id="firstTitle">
                        {{ __('families/trees.modal.first-title') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p id="modalHelper">
                        {{ __('families/trees.modal.helper') }}
                    </p>
                    <p id="firstHelper">
                        {{ __('families/trees.modal.first-helper') }}
                    </p>
                    {!! Form::foreignSelect(
                        'character_id',
                        [
                            'class' => App\Models\Entity::class,
                            'enableNew' => true,
                            'labelKey' => __('crud.fields.entity'),
                            'placeholderKey' => 'crud.placeholders.character',
                            'searchRouteName' => 'search.entities-with-relations',
                            'searchParams' => ['only' => config('entities.ids.character')]
                        ]
                    ) !!}

                    <div class="form-group mt-5" style="display: none" id="add-relation">
                        <label>{{ __('families/trees.modal.relation') }}</label>
                        {!! Form::text('relation', null, ['placeholder' => __('events.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button id='send' type="button" class="btn btn-success" data-toast="{{ __('crud.alerts.copy_mention') }}">
                        {{ __('crud.save') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
