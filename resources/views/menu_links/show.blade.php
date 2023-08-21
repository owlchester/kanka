<div class="entity-grid">

    @include('entities.components.menu_link_header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
        ]
    ])
</div>
