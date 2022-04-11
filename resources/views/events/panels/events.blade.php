<?php
$r = $model->descendants()->with('entity')->has('event')->simpleSort($datagridSorter)->paginate();
?>

<div class="box box-solid" id="event-events">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('events.fields.events') }}
        </h3>
    </div>
    <div class="box-body">

        @if($r->count() === 0)
            <div class="help-block">
                {{ __('events.events.helper') }}
            </div>
        @else

        <div class="row">
            <div class="col-md-6 col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#event-events'])
            </div>
        </div>

        <table id="events-table" class="table table-hover ">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('events.fields.name') }}</th>
                    <th>{{ __('crud.fields.type') }}</th>
                    <th>{{ __('events.fields.date') }}</th>
                    <th>{{ __('events.fields.event') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($r as $event)
                <tr class="{{ $event->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $event->getImageUrl(40) }}');" title="{{ $event->name }}" href="{{ route('events.show', $event->id) }}"></a>
                    </td>
                    <td>
                        @if ($event->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
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
                </tr>
            @endforeach
            </tbody>
        </table>

        @endif
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('event-events')->links() }}
        </div>
    @endif
</div>
