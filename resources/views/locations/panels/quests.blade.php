<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('locations.show.tabs.quests') }}
        </h2>

        <?php  $r = $model->relatedQuests()->paginate(); ?>
        <table id="location-quests" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('quests.fields.name') }}</th>
                <th class="hidden-sm">{{ __('quests.fields.role') }}</th>
                <th class="visible-sm">{{ __('quests.fields.type') }}</th>
                <th class="visible-sm">{{ __('quests.fields.quest') }}</th>
                @if ($campaign->enabled('locations'))
                    <th class="visible-sm">{{ __('quests.fields.locations') }}</th>
                @endif
                @if ($campaign->enabled('characters'))
                <th>{{ __('quests.fields.characters') }}</th>
                @endif
                <th>{{ __('quests.fields.is_completed') }}</th>
                <th>&nbsp;</th>
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
                            {{ $quest->locations()->count() }}
                        </td>
                    @endif
                    @if ($campaign->enabled('characters'))
                    <td>
                        {{ $quest->characters()->count() }}
                    </td>
                    @endif
                    <td>
                        @if ($quest->is_completed) <i class="fa fa-check-circle"></i> @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('quests.show', [$quest]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ __('crud.view') }}</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
