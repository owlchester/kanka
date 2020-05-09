<?php /** @var \App\Models\Character $model */?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header">
            {{ trans('characters.show.tabs.items') }}
        </h2>

        @include('cruds.datagrids.sorters.simple-sorter')

        <?php  $r = $model->items()->simpleSort($datagridSorter)->with(['location', 'entity', 'entity.tags'])->paginate(); ?>
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
                        <a class="entity-image" style="background-image: url('{{ $item->getImageUrl(40) }}');" title="{{ $item->name }}" href="{{ route('items.show', $item->id) }}"></a>
                    </td>
                    <td>
                        {!! $item->tooltipedLink() !!}
                    </td>
                    <td class="hidden-xs">{{ $item->type }}</td>
                    @if ($campaign->enabled('locations'))
                        <td class="hidden-xs">
                            @if ($item->location)
                                {!! $item->location->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('items.show', [$item]) }}" class="btn btn-xs btn-primary">
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
