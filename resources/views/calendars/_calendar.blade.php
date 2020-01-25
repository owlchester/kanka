<?php
/** @var \App\Renderers\CalendarRenderer $renderer
 * @var \App\Models\Calendar $model
 */
if ($model->missingDetails()): ?>
    <div class="alert alert-warning">
        {{ __('calendars.show.missing_details') }}
    </div>
<?php return;
endif;
$weekNumber = 1;
?>
@inject('renderer', 'App\Renderers\CalendarRenderer')
<?php $canEdit = auth()->check() && auth()->user()->can('update', $model) ?>
{{ $renderer->setCalendar($model) }}

<div class="calendar-toolbar">
    {{ $renderer->todayButton() }}
    <div class="btn-group">
        <a href="{{ $renderer->previous() }}" class="btn btn-default btn-corner-left" title="{{ $renderer->previous(true) }}" data-toggle="tooltip">
            <i class="fa fa-angle-left"></i>
        </a>
        <a href="{{ $renderer->next() }}" class="btn btn-default btn-corner-right" title="{{ $renderer->next(true) }}" data-toggle="tooltip">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
    <div class="calendar-current">
        @if (!$renderer->isYearlyLayout())
            <span class="month">{!! $renderer->currentMonthName() !!}</span>
        @endif
        <div data-toggle="modal" data-target="#calendar-year-switcher" title="{{ __('calendars.modals.switcher.title') }}"
            class="btn btn-default">
            {!! $renderer->currentYearName() !!}
        </div>
    </div>

    <div class="pull-right">
        <div class="btn-group">
            <a href="{{ route('calendars.show', [$model, 'layout' => 'year', 'year' => $renderer->currentYear()]) }}" class="btn btn-default btn-corner-left"<?=($renderer->isYearlyLayout() ? ' disabled="disabled"' : null)?>>{{ __('calendars.layouts.year') }}</a>
            <a href="{{ route('calendars.show', [$model, 'year' => $renderer->currentYear()]) }}" class="btn btn-default btn-corner-right"<?=(!$renderer->isYearlyLayout() ? ' disabled="disabled"' : null)?>>{{ __('calendars.layouts.month') }}</a>
        </div>
    </div>
    <div class="month-alias help-block">{!! $renderer->monthAlias() !!}</div>
</div>

@php $intercalary = $renderer->isIntercalaryMonth() @endphp
<table class="calendar table table-bordered table-striped">
    <thead>
    <tr>
        @foreach ($model->weekdays() as $weekday)
            <th>{{ $intercalary ? '' : $weekday }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @if ($renderer->isYearlyLayout())
        <tr>
        @foreach ($renderer->weeks() as $key => $day)
            @if($key % count($model->weekdays()) == 0)
                </tr><tr>

                @if (!empty($day) && !empty($day['week']))

                    @if ($renderer->isNamedWeek($day['week']))
                    <tr class="named_week">
                        <td colspan="{{ count($model->weekdays()) }}">
                            {{ $renderer->namedWeek($day['week']) }}
                        </td>
                    </tr>
                    @endif
                @endif
            @endif

            @include('calendars._day', ['showMonth' => true])
        @endforeach
        </tr>
    @else
        @foreach ($renderer->month() as $week => $days)
            @if (!empty($days) && $renderer->isNamedWeek($week))
                <tr class="named_week">
                    <td colspan="{{ count($model->weekdays()) }}">
                        {{ $renderer->namedWeek($week) }}
                    </td>
                </tr>
            @endif
            <tr>
            @foreach ($days as $day)
                @include('calendars._day')
            @endforeach
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="calendar-year-switcher" tabindex="-1" role="dialog" aria-labelledby="deleteYearSwitcherLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ __('calendars.modals.switcher.title') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => ['calendars.show', $model], 'method' => 'GET']) !!}
                {{ csrf_field() }}
                <div class="form-group">
                    <label>{{ __('calendars.fields.current_year') }}</label>
                    {!! Form::number('year', null, ['class' => 'form-control', 'placeholder' => e($renderer->currentYear())]) !!}
                </div>
                @if ($renderer->isYearlyLayout())
                    <input type="hidden" name="layout" value="yearly">
                @else
                    {!! Form::hidden('month', $renderer->currentMonthId()) !!}
                @endif
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"> {{ __('crud.click_modal.confirm') }}</button>
                {!! Form::close() !!}
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</button>
            </div>
        </div>
    </div>
</div>