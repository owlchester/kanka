<div class="print-box-attributes">

    <h2>{{ __('crud.tabs.attributes') }}</h2>
    @include('entities.pages.attributes.render', [
        'attributes' => $entity
            ->allRelationships()
            ->get(),
         'mode' => 'table'
    ])
</div>
