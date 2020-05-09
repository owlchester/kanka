<table id="character-quests" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
    <thead>
        <tr>
            <th class="avatar"><br /></th>
            <th>{{ trans('quests.fields.name') }}</th>
            @if ($role)<th class="hidden-sm">{{ trans('quests.fields.role') }}</th>@endif
            <th class="visible-sm">{{ trans('quests.fields.type') }}</th>
            <th class="visible-sm">{{ trans('quests.fields.quest') }}</th>
            @if ($campaign->enabled('locations'))
                <th class="visible-sm">{{ trans('quests.fields.locations') }}</th>
            @endif
            <th>{{ trans('quests.fields.characters') }}</th>
            <th>{{ trans('quests.fields.is_completed') }}</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($r as $quest)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $quest->getImageUrl(40) }}');" title="{{ $quest->name }}" href="{{ route('quests.show', $quest->id) }}"></a>
            </td>
            <td>
                {!! $quest->tooltipedLink() !!}
            </td>
            @if ($role)<td>
                {{ $quest->pivot->role }}
            </td>@endif
            <td class="visible-sm">{{ $quest->type }}</td>
            <td class="visible-sm">
                @if ($quest->quest)
                    {!! $quest->tooltipedLink() !!}
                @endif
            </td>
            @if ($campaign->enabled('locations'))
                <td class="visible-sm">
                    {{ $quest->locations()->count() }}
                </td>
            @endif
            <td>
                {{ $quest->characters()->count() }}
            </td>
            <td>
                @if ($quest->is_completed) <i class="fa fa-check-circle"></i> @endif
            </td>
            <td class="text-right">
                <a href="{{ route('quests.show', [$quest]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ trans('crud.view') }}</span>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->links() }}
