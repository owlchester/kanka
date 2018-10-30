<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('characters.show.tabs.quests') }}
        </h2>

        <?php  $r = $model->quests()->acl()->orderBy('name', 'ASC')->with(['characters', 'locations', 'quests'])->paginate(); ?>
        <table id="character-quests" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('quests.fields.name') }}</th>
                <th>{{ trans('quests.fields.type') }}</th>
                <th>{{ trans('quests.fields.quest') }}</th>
                @if ($campaign->enabled('locations'))
                    <th>{{ trans('quests.fields.locations') }}</th>
                @endif
                <th>{{ trans('quests.fields.characters') }}</th>
                <th>{{ trans('quests.fields.is_completed') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $quest)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $quest->getImageUrl(true) }}');" title="{{ $quest->name }}" href="{{ route('quests.show', $quest->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('quests.show', $quest->id) }}" data-toggle="tooltip" title="{{ $quest->tooltip() }}">{{ $quest->name }}</a>
                    </td>
                    <td>{{ $quest->type }}</td>
                    <td>
                        @if ($quest->quest)
                        <a href="{{ route('quests.show', $quest->quest->id) }}" data-toggle="tooltip" title="{{ $quest->quest->tooltip() }}">{{ $quest->quest->name }}</a>
                        @endif
                    </td>
                    @if ($campaign->enabled('locations'))
                        <td>
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
                        <a href="{{ route('quests.show', ['id' => $quest->id]) }}" class="btn btn-xs btn-primary">
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