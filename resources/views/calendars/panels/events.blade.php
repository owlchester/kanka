<?php
/** @var \App\Models\Calendar $model */
/** @var \App\Models\EntityEvent $event */
?>
<div class="box box-solid" id="calendar-events">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('calendars.show.tabs.events') }}
        </h3>
    </div>
    <div class="box-body">

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#calendar-events'])

        <?php  $r = $model->calendarEvents()->with('entity', 'calendar')->entityAcl()->simpleSort($datagridSorter)->paginate(); ?>
        <table id="calendar-events" class="table table-hover ">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('crud.fields.entity') }}</th>
                    <th>{{ __('crud.fields.entity_type') }}</th>
                    <th>{{ __('events.fields.date') }}</th>
                    <th>{{ __('calendars.fields.length') }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($r as $event)
                @if (empty($event->entity) || empty($event->entity->child))
                    @continue
                @endif
                <tr class="@if ($event->entity->is_private) entity-private @endif">
                    <td class="avatar">
                        <a class="entity-image" style="background-image: url('{{ $event->entity->child->getImageUrl(40) }}');" title="{{ $event->entity->name }}" href="{{ $event->entity->url() }}"></a>
                    </td>
                    <td>
                        @if ($event->entity->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $event->entity->tooltipedLink() !!}
                    </td>
                    <td>{{ $event->entity->entityType() }}</td>
                    <td>{{ $event->readableDate() }}</td>
                    <td>{{ trans_choice('calendars.fields.length_days', $event->length, ['count' => $event->length]) }}</td>
                    <td>@if ($event->comment)
                        <i class="fa fa-comment" title="{{ $event->comment }}" data-toggle="tooltip"></i>
                    @endif</td>
                    <td>@if ($event->is_recurring)
                        <i class="fa fa-refresh" title="{{ __('calendars.fields.is_recurring') }}" data-toggle="tooltip"></i>
                    @endif</td>
                    <td>
                        @can('update', $model)
                            <a href="{{ route('entities.entity_events.edit', [$event->entity, $event->id]) }}" class="btn btn-xs btn-primary" data-toggle="ajax-modal"
                               data-target="#entity-modal" data-url="{{ route('entities.entity_events.edit', [$event->entity->id, $event->id, 'next' => 'calendars.events']) }}"
                                title="{{ trans('crud.edit') }}">
                                <i class="fa fa-edit"></i>
                            </a>


                            <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $event->entity->name }}"
                                    data-target="#delete-confirm" data-delete-target="delete-form-{{ $event->id }}"
                                    title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_events.destroy', $event->entity, $event->id], 'style' => 'display:inline', 'id' => 'delete-form-' . $event->id]) !!}
                                <input type="hidden" name="next" value="calendars.events">
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('calendar-events')->links() }}
    </div>
</div>
