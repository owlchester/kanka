<div class="box box-solid">
    <div class="box-header with-header">
        <h3 class="box-title">
            {{ __('items.show.tabs.inventories') }}
        </h3>
    </div>
    <div class="box-body">

        <?php $r = $model->inventories()->acl()->orderBy('entity_id', 'ASC')->with(['entity'])->has('entity')->paginate(); ?>
        <table id="item-inventories" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('crud.fields.entity') }}</th>
                <th class="hidden-sm">{{ __('entities/inventories.fields.amount') }}</th>
                <th class="hidden-sm">{{ __('entities/inventories.fields.position') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $inventory)
                @if ($inventory->entity->child)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $inventory->entity->child->getImageUrl(40) }}');" title="{{ $inventory->entity->name }}" href="{{ $inventory->entity->url() }}"></a>
                    </td>
                    <td>
                        {!! $inventory->entity->tooltipedLink() !!}
                    </td>
                    <td class="hidden-sm">{{ $inventory->amount }}</td>
                    <td class="hidden-sm">{{ $inventory->position }}</td>
                    <td class="text-right">
                        <a href="{{ route('entities.inventory', $inventory->entity) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ __('crud.view') }}</span>
                        </a>
                    </td>
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
