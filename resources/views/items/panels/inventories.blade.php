<div class="box box-solid">
    <div class="box-header with-header">
        <h3 class="box-title">
            {{ __('items.show.tabs.inventories') }}
        </h3>
    </div>
    <div class="box-body">

        <?php $r = $model->inventories()->orderBy('entity_id', 'ASC')->with(['entity'])->has('entity')->paginate(); ?>
        <table id="item-inventories" class="table table-hover">
            <tbody><tr>
                <th class="min-w-10"><br /></th>
                <th>{{ __('crud.fields.entity') }}</th>
                <th class="hidden-sm">{{ __('entities/inventories.fields.amount') }}</th>
                <th class="hidden-sm">{{ __('entities/inventories.fields.position') }}</th>
            </tr>
            @foreach ($r as $inventory)
                @if ($inventory->entity->child)
                <tr data-entity-id="{{ $inventory->entity->id }}" data-entity-type="{{ $inventory->entity->type() }}" class="@if($inventory->entity->is_private) entity-private @endif">
                    <td>
                        <x-entities.thumbnail :entity="$inventory->entity" :title="$inventory->entity->name"></x-entities.thumbnail>
                    </td>
                    <td>
                        @if ($inventory->entity->is_private)
                            <i class="fa-solid fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $inventory->entity->tooltipedLink() !!}
                    </td>
                    <td class="hidden-sm">{{ $inventory->amount }}</td>
                    <td class="hidden-sm">{{ $inventory->position }}</td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->links() }}
        </div>
    @endif
</div>
