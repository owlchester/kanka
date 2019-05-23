<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.events') }}
        </h2>

        <?php  $r = $model->events()->acl()->orderBy('name', 'ASC')->with(['location'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.events') }}</p>
        <table id="events" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('events.fields.name') }}</th>
                <th>{{ trans('events.fields.type') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $event)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $event->getImageUrl(true) }}');" title="{{ $event->name }}" href="{{ route('events.show', $event->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('events.show', $event->id) }}" data-toggle="tooltip" title="{{ $event->tooltipWithName() }}" data-html="true">{{ $event->name }}</a>
                    </td>
                    <td>{{ $event->type }}</td>
                    <td class="text-right">
                        <a href="{{ route('events.show', ['id' => $event->id]) }}" class="btn btn-xs btn-primary">
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