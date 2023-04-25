<div class="print-box-inventory">

    <h2>{{ __('crud.tabs.inventory') }}</h2>
    @include('entities.pages.inventory._inventory', [
    'inventory' =>
            $entity->inventories()
            ->with(['entity', 'item', 'item.entity'])
            ->has('entity')
            ->get()
            ->sortBy(function($model, $key) {
                return !empty($model->position) ? $model->position : 'zzzz' . $model->itemName();
            })
])
</div>
