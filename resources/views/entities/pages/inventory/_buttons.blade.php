<a href="{{ route('entities.inventories.create', ['entity' => $entity]) }}" class="btn2 btn-accent btn-sm"
    data-toggle="ajax-modal" data-target="#entity-modal"
    data-url="{{ route('entities.inventories.create', ['entity' => $entity]) }}"
>
    <x-icon class="plus"></x-icon>
    {{ __('entities/inventories.actions.add') }}
</a>
