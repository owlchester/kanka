<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('locations.show.tabs.journals') }}
        </h3>
    </div>
    <div class="box-body">

        <?php  $r = $model->journals()->orderBy('name', 'ASC')->with(['character'])->paginate(); ?>
        <table id="location-journals" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('journals.fields.name') }}</th>
                <th class="hidden-sm">{{ __('journals.fields.type') }}</th>
                <th class="hidden-sm">{{ __('journals.fields.date') }}</th>
                @if ($campaign->enabled('characters'))
                <th>{{ __('journals.fields.author') }}</th>
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
                            <i class="fa fa-eye" aria-hidden="true"></i> <span class="visible-sm">{{ __('crud.view') }}</span>
                        </a>
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
