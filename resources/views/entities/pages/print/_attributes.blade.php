<div class="print-box-attributes">

    <h2>{{ __('entries/tabs.properties') }}</h2>
    @include('entities.pages.attributes.render', [
        'attributes' => $entity
            ->allRelationships()
            ->get(),
         'mode' => 'table'
    ])
</div>
