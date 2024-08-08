<x-box :padding="0">
    <?php $r = $model->inventories()->orderBy('entity_id', 'ASC')->with(['entity'])->has('entity')->paginate(); ?>
    <table id="item-inventories" class="table table-hover">
        <tbody><tr>
            <th class="avatar w-12"><br /></th>
            <th>{{ __('crud.fields.entity') }}</th>
            <th class="hidden md:block">{{ __('entities/inventories.fields.amount') }}</th>
            <th class="hidden md:block">{{ __('entities/inventories.fields.position') }}</th>
        </tr>
        @foreach ($r as $inventory)
            @if ($inventory->entity->child)
            <tr data-entity-id="{{ $inventory->entity->id }}" data-entity-type="{{ $inventory->entity->type() }}" class="@if($inventory->entity->is_private) entity-private @endif">
                <td>
                    <x-entities.thumbnail :entity="$inventory->entity" :title="$inventory->entity->name"></x-entities.thumbnail>
                </td>
                <td>
                    @if ($inventory->entity->is_private)
                        <x-icon class="fa-solid fa-lock" :title="{{ __('crud.is_private') }}" tooltip />
                    @endif
                    <x-entity-link
                        :entity="$inventory->entity"
                        :campaign="$campaign" />
                </td>
                <td class="hidden md:block">{{ $inventory->amount }}</td>
                <td class="hidden md:block">{{ $inventory->position }}</td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</x-box>

@if ($r->hasPages())
    <div class="text-right">
        {{ $r->links() }}
    </div>
@endif
