@extends('layouts.app', [
    'title' => __('families/trees.title', ['name' => $family->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $family,
])

@section('entity-header-actions')
    @can('update', $family)
        <div class="header-buttons">
            <a href="#" class="btn btn-sm btn-warning" id="tree-edit">
                <i class="fa-solid fa-edit" aria-hidden="true"></i> {{ __('crud.edit') }}
            </a>
            <a href="#" class="btn btn-sm btn-default" id="tree-reset" style="display: none">
                <i class="fa-solid fa-redo" aria-hidden="true"></i>
                {{ __('crud.actions.reset') }}
            </a>
            <a href="#" class="btn btn-sm btn-default" id="tree-clear" style="display: none">
                <i class="fa-solid fa-eraser" aria-hidden="true"></i>
                {{ __('families/trees.actions.clear') }}
            </a>
            <a href="#" class="btn btn-sm btn-primary" id="tree-save" style="display: none">
                <i class="fa-solid fa-save" aria-hidden="true"></i>
                {{ __('crud.save') }}
            </a>
        </div>
    @endcan
@endsection


@inject('campaignService', 'App\Services\CampaignService')

@section('content')
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
            <div class="family-tree-setup overflow-x overflow-y"
                data-api="{{ route('families.family-tree.api', $family) }}"
                data-save="{{ route('families.family-tree.api-save', $family) }}"
                data-entity="{{ route('families.family-tree.entity-api', 0) }}"
            >
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script src="{{ mix('js/family-tree.js') }}" defer></script>
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="add-entity" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('families/trees.modal.title') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('families/trees.modal.helper') }}
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
                    <button id='send' type="button" class="btn btn-success">
                        {{ __('crud.save') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
