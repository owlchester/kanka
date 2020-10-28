<?php
/**
 * @var \App\Models\Journal $model
 * @var \App\Models\Journal $journal
 */
$filters = [];
if (request()->has('journal_id')) {
    $filters['journal_id'] = request()->get('journal_id');
}
?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('journals.show.tabs.journals') }}
        </h2>


        <p class="help-block export-hidden">
            {{ trans('journals.helpers.journals') }}
        </p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">

                @if (request()->has('journal_id'))
                    <a href="{{ route('journals.journals', $model) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allJournals()->count() }})
                    </a>
                @else
                    <a href="{{ route('journals.journals', [$model, 'journal_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->journals()->count() }})
                    </a>
                @endif
            </div>
        </div>

        <?php  $r = $model->allJournals()->filter($filters)->simpleSort($datagridSorter)->with(['character', 'entity', 'entity.tags'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('journals.show.tabs.journalsJourn') }}</p>
        <table id="journals" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('journals.fields.name') }}</th>
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
                        {!! $journal->tooltipedLink() !!}<br />
                        <i>{{ $journal->type }}</i>
                    </td>
                    @if ($campaign->enabled('characters'))
                        <td>
                            @if ($journal->character)
                                {!! $journal->character->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('journals.show', [$journal]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->appends($filters)->links() }}
    </div>
</div>
