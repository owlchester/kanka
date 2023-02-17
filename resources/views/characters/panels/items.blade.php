<?php /** @var \App\Models\Character $model */?>
<div class="box box-solid" id="character-items">
    <div class="box-header">
        <h3 class="box-title">
            {{ trans('characters.show.tabs.items') }}
        </h3>
    </div>
    <div class="box-body">

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#character-items'])

        <?php  $r = $model->items()->simpleSort($datagridSorter)->with(['location', 'entity', 'entity.tags'])->paginate(); ?>
        <table id="character-items-table" class="table table-hover ">
            <tbody><tr>
                <th class="w-14"><br /></th>
                <th>{{ __('items.fields.name') }}</th>
                <th class="hidden-xs">{{ __('crud.fields.type') }}</th>
                @if ($campaign->enabled('locations'))
                    <th class="hidden-xs">{{ __('entities.location') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $item)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $item->thumbnail() }}');" title="{{ $item->name }}" href="{{ $item->getLink() }}"></a>
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
                        <a href="{{ $item->getLink() }}" class="btn btn-xs btn-primary">
                            <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('character-items')->links() }}
    </div>
</div>
