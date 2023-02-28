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
<div class="box box-solid">
    <div class="box-body">
        <div class="calendar-toolbar">
            {{ $renderer->todayButton() }}

            @if (!$renderer->isYearlyLayout())
            <div class="btn-group">
                <a href="{{ $renderer->previous() }}" class="btn btn-default btn-corner-left" data-shortcut="previous" title="{{ $renderer->previous(true) }} (Ctrl <i class='fa-solid fa-arrow-left' aria-hidden='true'></i>)" data-html="true" data-toggle="tooltip">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
                <div class="btn btn-default" disabled>
                    {!! $renderer->currentMonthName() !!}
                </div>
                <a href="{{ $renderer->next() }}" class="btn btn-default btn-corner-right"  data-shortcut="next" title="{{ $renderer->next(true) }} (Ctrl <i class='fa-solid fa-arrow-right' aria-hidden='true'></i>)" data-html="true" data-toggle="tooltip">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            </div>
            @endif
            <div class="btn-group">
                <a href="{{ $renderer->linkToYear(false) }}" class="btn btn-default btn-corner-left" @if ($renderer->isYearlyLayout()) data-shortcut="previous" title="{{ $renderer->titleToYear(false) }} (Ctrl <i class='fa-solid fa-arrow-left' aria-hidden='true'></i>)" data-html="true" @else title="{{ $renderer->titleToYear(false) }}" @endif data-toggle="tooltip">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
                <div data-toggle="modal" data-target="#calendar-year-switcher" title="{{ __('calendars.modals.switcher.title') }}"
                     class="btn btn-default">
                    {!! $renderer->currentYearName() !!}
                </div>
                <a href="{{ $renderer->linkToYear() }}" class="btn btn-default btn-corner-right" @if ($renderer->isYearlyLayout()) data-shortcut="next" title="{{ $renderer->titleToYear() }} (Ctrl <i class='fa-solid fa-arrow-right' aria-hidden='true'></i>)" data-html="true" @else title="{{ $renderer->titleToYear() }}" @endif data-toggle="tooltip">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            </div>

            <div class="pull-right">
                <div class="btn-group">
                    <a href="{{ route('calendars.show', [$model, 'layout' => 'year', 'year' => $renderer->currentYear()]) }}" class="btn btn-default btn-corner-left"<?=($renderer->isYearlyLayout() ? ' disabled="disabled"' : null)?>>{{ __('calendars.layouts.year') }}</a>
                    <a href="{{ route('calendars.show', array_merge([$model, 'year' => $renderer->currentYear()], $model->defaultLayout() === 'year' ? ['layout' => 'month'] : [])) }}" class="btn btn-default btn-corner-right"<?=(!$renderer->isYearlyLayout() ? ' disabled="disabled"' : null)?>>{{ __('calendars.layouts.month') }}</a>
                </div>
            </div>
            <div class="month-alias help-block">{!! $renderer->monthAlias() !!}</div>
        </div>
    </div>
    <div class="box-body no-padding">
@php $intercalary = $renderer->isIntercalaryMonth() @endphp
<table class="calendar table table-striped">
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
        @foreach ($renderer->buildForYear() as $key => $day)
            @if($key % count($model->weekdays()) == 0)
                </tr><tr>
                @if (!empty($day) && !empty($day['week']))
                    @if ($renderer->isNamedWeek($day['week']))
                        <tr class="named_week italic h-4 week-nr-{{ $day['week'] }}">
                            <td colspan="{{ count($model->weekdays()) }}" class="h-4">
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
        @foreach ($renderer->buildForMonth() as $week => $days)
            @if (!empty($days) && $renderer->isNamedWeek($week))
                <tr class="named_week italic week-nr-{{ $week }}">
                    <td colspan="{{ count($model->weekdays()) }}" class="h-4">
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
    </div>
</div>

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
                <div class="form-group">
                    <label>{{ __('calendars.fields.year') }}</label>
                    {!! Form::number('year', null, ['class' => 'form-control', 'placeholder' => e($renderer->currentYear())]) !!}
                </div>
                @if ($renderer->isYearlyLayout() && !$model->yearlyLayout())
                    <input type="hidden" name="layout" value="year">
                @else
                    @if ($model->yearlyLayout())
                        <input type="hidden" name="layout" value="month">
                    @endif
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
