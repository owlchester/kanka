<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
<table class="table table-hover table-entity-inventory">
    <thead>
    <tr>
        <th>{{ __('entities/inventories.fields.is_equipped') }}</th>
        <th>{{ __('crud.fields.item') }}</th>
        <th>{{ __('entities/inventories.fields.amount') }}</th>
        @if (Auth::check())
            <th>{{ __('crud.fields.visibility') }}</th>
            <th></th>
        @endif
    </tr>
    </thead>
    <tbody>
    <?php $previousPosition = null; ?>
    @foreach ($inventory as $item)
        @if(!empty($item->item_id) && empty($item->item))
            @continue
        @endif
        @if ($previousPosition != $item->position)
            <tr class="active cursor" data-toggle="collapse" data-target=".inventory-group-{{ \Illuminate\Support\Str::kebab($item->position) }}">
                <td colspan="@if(Auth::check())5 @else 4 @endif" class="text-muted">
                    {!! $item->position ?: '<i>' . __('entities/inventories.show.unsorted') . '</i>' !!}
                </td>
            </tr>
            <?php $previousPosition = $item->position; ?>
        @endif
        <tr class="collapse inventory-group-{{ \Illuminate\Support\Str::kebab($item->position) }} in">
            <td style="width: 50px">
                @if($item->is_equipped)
                    <i class="fas fa-check" title="{{ __('entities/inventories.fields.is_equipped') }}"></i>
                @endif
            </td>
            <td>
                @if($item->item)
                    {!! $item->item->tooltipedLink($item->name) !!}
                @else
                    {!! $item->name !!}
                @endif<br />
                <small class="text-muted">{{ $item->description }}</small>
            </td>
            <td>
                {{ $item->amount }}
            </td>
            @if (Auth::check())
                <td>
                    @include('cruds.partials.visibility', ['model' => $item])
                </td>
                @can('inventory', $entity->child)
                    <td class="text-right">
                        <a href="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item->id]) }}"
                           data-toggle="ajax-modal" data-target="#entity-modal"
                           data-url="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item->id]) }}"
                           title="{{ __('crud.edit') }}" class="btn btn-primary btn-xs">
                            <i class="fa fa-edit"></i>
                        </a>

                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $item->itemName() }}"
                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $item->id }}" title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['entities.inventories.destroy', 'entity' => $entity, 'inventory' => $item], 'style' => 'display:inline', 'id' => 'delete-form-' . $item->id]) !!}
                        {!! Form::close() !!}
                    </td>
                @endcan
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
