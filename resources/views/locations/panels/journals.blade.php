<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.journals') }}
        </h2>

        <?php  $r = $model->journals()->orderBy('name', 'ASC')->with(['character'])->paginate(); ?>
        <table id="location-journals" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('journals.fields.name') }}</th>
                <th class="hidden-sm">{{ trans('journals.fields.type') }}</th>
                <th class="hidden-sm">{{ trans('journals.fields.date') }}</th>
                @if ($campaign->enabled('characters'))
                <th>{{ trans('journals.fields.author') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $journal)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $journal->getImageUrl(40) }}');" title="{{ $journal->name }}" href="{{ route('journals.show', $journal->id) }}"></a>
                    </td>
                    <td>
                        {!! $journal->tooltipedLink() !!}
                    </td>
                    <td class="hidden-sm">{{ $journal->type }}</td>
                    <td class="hidden-sm">{{ $journal->date }}</td>
                    @if ($campaign->enabled('characters'))
                    <td>
                        @if ($journal->character)
                            {!! $journal->character->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('journals.show', [$journal]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ trans('crud.view') }}</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
