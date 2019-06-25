<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.organisations') }}
        </h2>

        <?php  $r = $model->organisations()->orderBy('name', 'ASC')->with(['members'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.organisations') }}</p>
        <table id="items" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('organisations.fields.name') }}</th>
                <th>{{ trans('organisations.fields.type') }}</th>
                @if ($campaign->enabled('characters'))<th>{{ trans('organisations.fields.members') }}</th>@endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $org)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $org->getImageUrl(true) }}');" title="{{ $org->name }}" href="{{ route('items.show', $org->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('organisations.show', $org->id) }}" data-toggle="tooltip" title="{{ $org->tooltipWithName() }}" data-html="true">{{ $org->name }}</a>
                    </td>
                    <td>{{ $org->type }}</td>

                    @if ($campaign->enabled('characters'))<td>
                        {{ $org->members()->count() }}
                    </td>@endif
                    <td class="text-right">
                        <a href="{{ route('organisations.show', ['id' => $org->id]) }}" class="btn btn-xs btn-primary">
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