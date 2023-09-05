<a href="{{ route('entities.inventories.create', [$campaign, 'entity' => $entity]) }}" class="btn2 btn-sm"
    data-toggle="dialog" data-target="inventory-dialog"
    data-url="{{ route('entities.inventories.create', [$campaign, 'entity' => $entity]) }}"
>
    <x-icon class="plus"></x-icon>
    {{ __('entities/inventories.actions.add') }}
</a>
