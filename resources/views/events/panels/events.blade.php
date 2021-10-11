<?php
$r = $model->descendants()->with('entity')->has('event')->simpleSort($datagridSorter)->paginate();
?>

<div class="box box-solid" id="event-events">
    <div class="box-header with-border">
        <h2 class="box-title">
            {{ __('events.fields.events') }}
        </h2>
    </div>
    <div class="box-body">

        @if($r->count() === 0)
            <div class="help-block">
                {{ __('events.events.helper') }}
            </div>
        @else

        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('events.show.tabs.events') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#event-events'])

        <table id="events-table" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
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

        {{ $r->fragment('event-events')->links() }}

        @endif
    </div>
</div>
