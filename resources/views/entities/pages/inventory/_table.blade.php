
@if ($inventory->count() === 0)
    <x-box>
        <p class="help-block">{{ __('entities/inventories.show.helper') }}</p>

        @can('inventory', $entity->child)
            <a href="{{ route('entities.inventories.create', ['entity' => $entity]) }}" class="btn2 btn-accent btn-sm"
                data-toggle="ajax-modal" data-target="#entity-modal"
                data-url="{{ route('entities.inventories.create', ['entity' => $entity]) }}"
            >
                <x-icon class="plus"></x-icon>
                {{ __('entities/inventories.actions.add') }}
            </a>
        @endcan
    </x-box>
@else
<x-box :padding="false" css="box-entity-inventory">
    @includeWhen($inventory->count() > 0, 'entities.pages.inventory._inventory')
</x-box>
@endif
