<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('locations.show.tabs.events') }}
        </h2>

        <?php  $r = $model->events()->orderBy('name', 'ASC')->with(['location'])->paginate(); ?>

        <table id="events" class="table table-hover ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('events.fields.name') }}</th>
                <th>{{ __('events.fields.type') }}</th>
                <th>{{ __('events.fields.date') }}</th>
            </tr>
            @foreach ($r as $event)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $event->getImageUrl(40) }}');" title="{{ $event->name }}" href="{{ route('events.show', $event->id) }}"></a>
                    </td>
                    <td>
                        {!! $event->tooltipedLink() !!}
                    </td>
                    <td>{{ $event->type }}</td>
                    <td>{{ $event->date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
