@extends('layouts.app', [
    'title' => __('families/trees.title', ['name' => $family->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $family,
])

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
    <script>
    function editEntity(this) {
        this.newEntity = 'test';
    }
    </script>
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
