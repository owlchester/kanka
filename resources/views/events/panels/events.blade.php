<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('events.fields.events') }}
        </h2>

        <?php  $r = $model->descendants()->with('entity')->simpleSort($datagridSorter)->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('events.show.tabs.events') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter')

        <table id="events" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('events.fields.name') }}</th>
                <th>{{ __('crud.fields.type') }}</th>
                <th>{{ __('events.fields.date') }}</th>
                <th>{{ __('events.fields.event') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $event)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $event->getImageUrl(40) }}');" title="{{ $event->name }}" href="{{ route('events.show', $event->id) }}"></a>
                    </td>
                    <td>
                        {!! $event->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $event->type }}
                    </td>
                    <td>
                        {{ $event->date }}
                    </td>
                    <td>
                        {!! $event->event->tooltipedLink() !!}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('events.show', [$event]) }}" class="btn btn-xs btn-primary">
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
