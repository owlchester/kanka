<table class="table no-border table-condensed table-hover">
@foreach ($model->items as $item)
    <tr>
        <td class="avatar">
            <a class="entity-image" style="background-image: url('{{ $item->getImageUrl(true) }}');" title="{{ $item->name }}" href="{{ route('items.show', $item->id) }}"></a>
        </td>
        <td>
            <a href="{{ route('items.show', $item->id) }}" data-toggle="tooltip" title="{{ $item->tooltip() }}" class="entity-name">
                {{ $item->name }}
            </a><br />
            {{ $item->type }}
        </td>
    </tr>
@endforeach
</table>