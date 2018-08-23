<table class="table no-border">
@foreach ($r = $model->conversations()->orderBy('name', 'ASC')->paginate() as $related)
    <tr>
        <td class="avatar">
            <a class="entity-image" style="background-image: url('{{ $related->getImageUrl(true) }}');" title="{{ $related->name }}" href="{{ route('conversations.show', $related->id) }}"></a>
        </td>
        <td>
            <a href="{{ route('conversations.show', $related->id) }}" data-toggle="tooltip" title="{{ $related->tooltip() }}" class="entity-name">
                {{ $related->name }}
            </a>
        </td>
    </tr>
@endforeach
</table>

{{ $r->links() }}