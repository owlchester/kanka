<table class="table no-border">
    @foreach ($model->quests()->with('quest')->has('quest')->get() as $r)
        <tr>
            <td class="avatar">
                <a class="entity-image" style="background-image: url('{{ $r->quest->getImageUrl(true) }}');" title="{{ $r->quest->name }}" href="{{ route('quests.show', $r->quest->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('quests.show', $r->quest_id) }}" data-toggle="tooltip" title="{{ $r->quest->tooltip() }}" class="entity-name">
                    {{ $r->quest->name }}
                </a>
            </td>
        </tr>
@endforeach
</table>