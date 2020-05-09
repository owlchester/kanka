@inject('dateRenderer', App\Renderers\DateRenderer)
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header ">
            {{ trans('characters.show.tabs.journals') }}
        </h2>

        <?php  $r = $model->journals()->orderBy('name', 'ASC')->with([
            'entity', 'entity.tags'
        ])->paginate(); ?>
        <table id="character-journals" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('journals.fields.name') }}</th>
                <th class="visible-sm">{{ trans('journals.fields.type') }}</th>
                <th class="visible-sm">{{ trans('journals.fields.date') }}</th>
                <th>{{ trans('crud.fields.calendar_date') }}</th>
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
                    <td class="visible-sm">{{ $journal->type }}</td>
                    <td class="visible-sm">{{ $dateRenderer->render($journal->date) }}</td>
                    <td>{{ $dateRenderer->render($journal->getDate()) }}</td>
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
