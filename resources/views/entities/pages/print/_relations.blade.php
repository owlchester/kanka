<div class="print-box-relations">
    <h2>{{ __('crud.tabs.relations') }}</h2>

    @include('entities.pages.relations._table', [
        'relations' => $entity
            ->allRelationships()
            ->get(),
         'mode' => 'table'
    ])
</div>
