<?php
/**
 * @var \App\Models\Journal $model
 * @var \App\Models\Journal $journal
 */
$filters = [];
if (request()->has('journal_id')) {
    $filters['journal_id'] = request()->get('journal_id');
}
$r = $model->allJournals()
        ->filter($filters)
        ->simpleSort($datagridSorter)
        ->with(['character', 'entity', 'entity.tags'])
        ->paginate();
?>
<div class="box box-solid" id="journal-journals">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('journals.show.tabs.journals') }}
        </h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
            @if (request()->has('journal_id'))
                <a href="{{ route('journals.journals', [$model, '#journal-journals']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allJournals()->count() }})
                </a>
            @else
                <a href="{{ route('journals.journals', [$model, 'journal_id' => $model->id, '#journal-journals']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->journals()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#journal-journals'])
            </div>
            <div class="col-md-6 text-right">


            </div>
        </div>

        <table id="journals" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('journals.fields.name') }}</th>
                @if ($campaign->enabled('characters'))
                    <th>{{ __('journals.fields.author') }}</th>
                @endif
            </tr>
            @foreach ($r as $journal)
                <tr class="{{ $journal->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $journal->getImageUrl(40) }}');" title="{{ $journal->name }}" href="{{ route('journals.show', $journal->id) }}"></a>
                    </td>
                    <td>
                        @if ($journal->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('journal-journals')->appends($filters)->links() }}
        </div>
    @endif
</div>

@section('modals')
    @parent
    <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('crud.actions.help') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('journals.helpers.journals') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
