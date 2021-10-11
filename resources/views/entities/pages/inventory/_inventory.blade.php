<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
<div class="table-responsive">
<table class="table table-striped table-entity-inventory">
    <thead>
    <tr>
        <th colspan="2">{{ __('crud.fields.item') }}</th>
        <th>{{ __('entities/inventories.fields.qty') }}</th>
        @if (Auth::check())
            <th><i class="fa fa-user-lock" title="{{ __('crud.fields.visibility') }}" data-toggle="tooltip"></i></th>
            <th><br /></th>
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
                <th colspan="@if(Auth::check())5 @else 4 @endif" class="text-muted">
                    {!! $item->position ?: '<i>' . __('entities/inventories.show.unsorted') . '</i>' !!}
                </th>
            </tr>
            <?php $previousPosition = $item->position; ?>
        @endif
        <tr class="collapse inventory-group-{{ \Illuminate\Support\Str::kebab($item->position) }} in">
            <td style="width: 50px">
                @if($item->is_equipped)
                    <i class="fas fa-check" title="{{ __('entities/inventories.fields.is_equipped') }}" data-toggle="tooltip"></i>
                @endif
            </td>
            <td>
                @if($item->item)
                    {!! $item->item->tooltipedLink($item->name) !!}
                @else
                    {!! $item->name !!}
                @endif<br />
                <small class="text-muted">
                    @if ($item->item && $item->copy_item_entry)
                        {!! $item->item->entry() !!}
                    @else
                    {{ $item->description }}
                    @endif
                </small>
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
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-xs btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right" href="#">
                                <i class="fa fa-ellipsis-h" data-tree="escape"></i>
                                <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li>
                                    <a href="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item->id]) }}"
                                       data-toggle="ajax-modal" data-target="#entity-modal"
                                       data-url="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item->id]) }}"
                                       title="{{ __('crud.edit') }}">
                                        <i class="fa fa-edit"></i> {{ __('crud.edit') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-danger delete-confirm" data-toggle="modal" data-name="{!! $item->itemName() !!}"
                                       data-target="#delete-confirm" data-delete-target="delete-form-{{ $item->id }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        {{ __('crud.remove') }}
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.inventories.destroy', 'entity' => $entity, 'inventory' => $item], 'style' => 'display:inline', 'id' => 'delete-form-' . $item->id]) !!}
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </div>
                    </td>
                @endcan
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
</div>
