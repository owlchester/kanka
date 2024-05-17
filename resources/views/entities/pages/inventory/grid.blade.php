<div class="box-entity-inventory">
    @includeWhen($entity->orderedInventory()->count() > 0, 'entities.pages.inventory._grid')
</div>
