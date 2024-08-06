<a href="{{ route('entities.inventories.create', [$campaign, $entity]) }}" class="btn2 btn-sm"
    data-toggle="dialog" data-target="primary-dialog"
    data-url="{{ route('entities.inventories.create', [$campaign, $entity]) }}"
>
    <x-icon class="plus" />
    {{ __('entities/inventories.actions.add') }}
</a>

<a href="{{ route('entities.inventory.copy', [$campaign, $entity]) }}" class="btn2 btn-sm"
    data-toggle="dialog" data-target="primary-dialog"
    data-url="{{ route('entities.inventory.copy', [$campaign, $entity]) }}"
>
    <x-icon class="copy" />
    {{ __('entities/inventories.actions.copy_from') }}
</a>
