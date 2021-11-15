<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('locations.show.tabs.items') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->items()->orderBy('name', 'ASC')->with(['character'])->paginate(); ?>

        <table id="items" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('items.fields.name') }}</th>
                <th>{{ __('items.fields.type') }}</th>
                @if ($campaign->enabled('characters'))<th>{{ __('crud.fields.character') }}</th>@endif
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
                </tr>
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
