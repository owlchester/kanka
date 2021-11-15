<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ trans('organisations.show.tabs.quests') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->relatedQuests()->paginate(); ?>
        <table id="organisation-quests" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('quests.fields.name') }}</th>
                <th class="hidden-sm">{{ trans('quests.fields.role') }}</th>
                <th class="visible-sm">{{ trans('quests.fields.type') }}</th>
                <th class="visible-sm">{{ trans('quests.fields.quest') }}</th>
                @if ($campaign->enabled('locations'))
                    <th class="visible-sm">{{ trans('quests.fields.locations') }}</th>
                @endif
                @if ($campaign->enabled('characters'))
                <th>{{ trans('quests.fields.characters') }}</th>
                @endif
                <th>{{ trans('quests.fields.is_completed') }}</th>
            </tr>
            @foreach ($r as $quest)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $quest->getImageUrl(40) }}');" title="{{ $quest->name }}" href="{{ route('quests.show', $quest->id) }}"></a>
                    </td>
                    <td>
                        {!! $quest->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $quest->pivot->role }}
                    </td>
                    <td class="visible-sm">{{ $quest->type }}</td>
                    <td class="visible-sm">
                        @if ($quest->quest)
                            {!! $quest->quest->tooltipedLink() !!}
                        @endif
                    </td>
                    @if ($campaign->enabled('locations'))
                        <td class="visible-sm">
                            {{ $quest->locations->count() }}
                        </td>
                    @endif
                    @if ($campaign->enabled('characters'))
                    <td>
                        {{ $quest->characters->count() }}
                    </td>
                    @endif
                    <td>
                        @if ($quest->is_completed) <i class="fa fa-check-circle"></i> @endif
                    </td>
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
