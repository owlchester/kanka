<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('items.show.tabs.inventories') }}
        </h2>

        <?php  $r = $model->inventories()->acl()->orderBy('entity_id', 'ASC')->with(['entity'])->paginate(); ?>
        <table id="item-inventories" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('crud.fields.entity') }}</th>
                <th class="hidden-sm">{{ trans('entities/inventories.fields.amount') }}</th>
                <th class="hidden-sm">{{ trans('entities/inventories.fields.position') }}</th>
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
                            <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ trans('crud.view') }}</span>
                        </a>
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
