<?php
/** @var \App\Models\Calendar $model */
/** @var \App\Models\EntityEvent $event */
?>
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('calendars.show.tabs.events') }}
        </h2>

        <?php  $r = $model->calendarEvents()->with('entity')->entityAcl()->orderByRaw('date(`date`) DESC')->paginate(); ?>
        <table id="calendar-events" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('crud.fields.entity') }}</th>
                    <th>{{ __('events.fields.date') }}</th>
                    <th>{{ __('calendars.fields.length') }}</th>
                    <th>{{ __('calendars.fields.comment') }}</th>
                    <th>{{ __('calendars.fields.is_recurring') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($r as $event)
                <tr>
                    <td class="avatar">
                        <a class="entity-image" style="background-image: url('{{ $event->entity->child->getImageUrl(true) }}');" title="{{ $event->entity->name }}" href="{{ $event->entity->url() }}"></a>
                    </td>
                    <td>
                        <a href="{{ $event->entity->url() }}">{{ $event->entity->name }}</a>
                    </td>
                    <td>{{ $event->getDate() }}</td>
                    <td>{{ trans_choice('calendars.fields.length_days', $event->length, ['count' => $event->length]) }}</td>
                    <td>{{ $event->comment }}</td>
                    <td>@if ($event->is_recurring)
                        <i class="fa fa-check"></i>
                    @endif</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>