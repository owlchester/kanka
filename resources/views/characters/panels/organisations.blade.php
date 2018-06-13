<table class="table no-border table-condensed table-hover">
    @foreach ($model->organisations()->with('organisation')->has('organisation')->get() as $r)
        <tr>
            <td class="avatar">
                <a class="entity-image" style="background-image: url('{{ $r->organisation->getImageUrl(true) }}');" title="{{ $r->organisation->name }}" href="{{ route('organisations.show', $r->organisation->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('organisations.show', $r->organisation_id) }}" data-toggle="tooltip" title="{{ $r->organisation->tooltip() }}" class="entity-name">
                    {{ $r->organisation->name }}
                </a><br />
                {{ $r->role }}
            </td>
        </tr>
@endforeach
</table>