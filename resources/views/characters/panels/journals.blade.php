<table class="table no-border">
@foreach ($model->journals as $journal)
    <tr>
        <td class="avatar">
            <a class="entity-image" style="background-image: url('{{ $journal->getImageUrl(true) }}');" title="{{ $journal->name }}" href="{{ route('journals.show', $journal->id) }}"></a>
        </td>
        <td>
            <a href="{{ route('journals.show', $journal->id) }}" data-toggle="tooltip" title="{{ $journal->tooltip() }}" class="entity-name">
                {{ $journal->name }}
            </a>
        </td>
    </tr>
@endforeach
</table>