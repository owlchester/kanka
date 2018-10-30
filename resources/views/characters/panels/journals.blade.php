<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('characters.show.tabs.journals') }}
        </h2>

        <?php  $r = $model->journals()->acl()->orderBy('name', 'ASC')->with([])->paginate(); ?>
        <table id="character-journals" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('journals.fields.name') }}</th>
                <th>{{ trans('journals.fields.type') }}</th>
                <th>{{ trans('journals.fields.date') }}</th>
                <th>{{ trans('crud.fields.calendar_date') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $journal)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $journal->getImageUrl(true) }}');" title="{{ $journal->name }}" href="{{ route('journals.show', $journal->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('journals.show', $journal->id) }}" data-toggle="tooltip" title="{{ $journal->tooltip() }}">{{ $journal->name }}</a>
                    </td>
                    <td>{{ $journal->type }}</td>
                    <td>{{ $dateRenderer->render($journal->date) }}</td>
                    <td>{{ $dateRenderer->render($journal->getDate()) }}</td>
                    <td class="text-right">
                        <a href="{{ route('journals.show', ['id' => $journal->id]) }}" class="btn btn-xs btn-primary">
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