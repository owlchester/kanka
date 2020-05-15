<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.items') }}
        </h2>

        <?php  $r = $model->items()->orderBy('name', 'ASC')->with(['character'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.items') }}</p>
        <table id="items" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('items.fields.name') }}</th>
                <th>{{ trans('items.fields.type') }}</th>
                @if ($campaign->enabled('characters'))<th>{{ trans('crud.fields.character') }}</th>@endif
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
                    <td>{{ $item->type }}</td>

                    @if ($campaign->enabled('characters'))<td>
                        @if ($item->character)
                            {!! $item->character->tooltipedLink() !!}
                        @endif
                    </td>@endif
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
