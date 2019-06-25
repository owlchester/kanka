<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('characters.show.tabs.items') }}
        </h2>

        <?php  $r = $model->items()->orderBy('name', 'ASC')->with(['location', 'entity', 'entity.tags'])->paginate(); ?>
        <table id="character-items" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('items.fields.name') }}</th>
                <th class="hidden-xs">{{ trans('items.fields.type') }}</th>
                @if ($campaign->enabled('locations'))
                    <th class="hidden-xs">{{ trans('crud.fields.location') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $item)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $item->getImageUrl(true) }}');" title="{{ $item->name }}" href="{{ route('items.show', $item->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('items.show', $item->id) }}" data-toggle="tooltip" title="{{ $item->tooltipWithName() }}" data-html="true">{{ $item->name }}</a>
                    </td>
                    <td class="hidden-xs">{{ $item->type }}</td>
                    @if ($campaign->enabled('locations'))
                        <td class="hidden-xs">
                            @if ($item->location)
                                <a href="{{ route('locations.show', $item->location_id) }}" data-toggle="tooltip" title="{{ $item->location->tooltipWithName() }}" data-html="true">{{ $item->location->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('items.show', ['id' => $item->id]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>