<?php
/** @var \App\Renderers\CalendarRenderer $renderer
 * @var \App\Models\Entity $entity
 * @var \App\Models\Calendar $model
 */
if ($model->missingDetails()): ?>
    <x-alert type="warning">
        {{ __('calendars.show.missing_details') }}
    </x-alert>
<?php return;
endif;
$weekNumber = 1;
?>
@inject('renderer', 'App\Renderers\CalendarRenderer')
@inject('colours', 'App\Services\ColourService')
<?php $canEdit = auth()->check() && auth()->user()->can('update', $entity) ?>
{{ $renderer->campaign($campaign)->setCalendar($model) }}

<div class="calendar-toolbar flex gap-2 items-center">
    <a
        href="{{ route('entities.show', [$campaign, 'entity' => $entity, 'month' => $renderer->currentMonthId(), 'year' => $renderer->currentYear()]) }}"
        class="btn2 btn-sm @if ($renderer->todayButtonIsDisabled()) btn-disabled" disabled="disabled @endif"
    >
        {{ __('calendars.actions.today') }}
    </a>

    @if (!$renderer->isYearlyLayout())
    <div class="join">
        <a href="{{ $renderer->previous() }}" class="btn2 join-item btn-sm" data-shortcut="previous" data-title="{{ $renderer->previous(true) }} (Ctrl <i class='fa-solid fa-arrow-left' aria-hidden='true'></i>)" data-html="true" data-toggle="tooltip">
            <x-icon class="fa-solid fa-chevron-left" />
        </a>
        <div class="btn2 join-item btn-sm btn-disabled" disabled>
            {!! $renderer->currentMonthName() !!}
        </div>
        <a href="{{ $renderer->next() }}" class="btn2 join-item btn-sm" data-shortcut="next" data-title="{{ $renderer->next(true) }} (Ctrl <i class='fa-solid fa-arrow-right' aria-hidden='true'></i>)" data-html="true" data-toggle="tooltip">
            <x-icon class="fa-solid fa-chevron-right" />
        </a>
    </div>
    @endif
    <div class="join grow">
        <a href="{{ $renderer->linkToYear(false) }}" class="btn2 join-item btn-sm" @if ($renderer->isYearlyLayout()) data-shortcut="previous" data-title="{{ $renderer->titleToYear(false) }} (Ctrl <i class='fa-solid fa-arrow-left' aria-hidden='true'></i>)" data-html="true" @else data-title="{{ $renderer->titleToYear(false) }}" @endif data-toggle="tooltip">
            <x-icon class="fa-solid fa-chevron-left" />
        </a>
        <div data-toggle="dialog" data-target="calendar-year-switcher" title="{{ __('calendars.modals.switcher.title') }}"
             class="btn2 join-item btn-sm">
            {!! $renderer->currentYearName() !!}
        </div>
        <a href="{{ $renderer->linkToYear() }}" class="btn2 join-item btn-sm" @if ($renderer->isYearlyLayout()) data-shortcut="next" data-title="{{ $renderer->titleToYear() }} (Ctrl <i class='fa-solid fa-arrow-right' aria-hidden='true'></i>)" data-html="true" @else data-title="{{ $renderer->titleToYear() }}" @endif data-toggle="tooltip">
            <x-icon class="fa-solid fa-chevron-right" />
        </a>
    </div>

    <div class="join">
        <a href="{{ route('entities.show', [$campaign, $entity, 'layout' => 'year', 'year' => $renderer->currentYear()]) }}"
           class="btn2 join-item btn-sm  <?=($renderer->isYearlyLayout() ? 'btn-disabled" disabled="disabled' : null)?>">
            {{ __('calendars.layouts.year') }}
        </a>
        <a href="{{ route('entities.show', array_merge([$campaign, $entity, 'year' => $renderer->currentYear()], $model->defaultLayout() === 'year' ? ['layout' => 'month'] : [])) }}"
           class="btn2 join-item btn-sm <?=(!$renderer->isYearlyLayout() ? ' btn-disabled" disabled="disabled' : null)?>">
            {{ __('calendars.layouts.month') }}
        </a>
    </div>
    <div class="month-alias help-block m-0">{!! $renderer->monthAlias() !!}</div>
</div>

<x-box :padding="false">
@php $intercalary = $renderer->isIntercalaryMonth() @endphp
<table class="calendar table table-striped table-fixed">
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
                            <td colspan="{{ count($model->weekdays()) }}" class="bg-week h-1 break-words">
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
                    <td colspan="{{ count($model->weekdays()) }}" class="h-4 break-words">
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
</x-box>

@section('modals')
    @parent
    <x-form :action="['entities.show', $campaign, $entity]" method="GET">
        <x-dialog id="calendar-year-switcher" :title="__('calendars.modals.switcher.title')" footer="calendars.year-switcher._footer">
            <x-forms.field field="year" :label="__('calendars.fields.year')">
                <input type="number" name="year" autofocus placeholder="{{ $renderer->currentYear() }}" />
            </x-forms.field>

            @if ($renderer->isYearlyLayout() && !$model->yearlyLayout())
                <input type="hidden" name="layout" value="year">
            @else
                @if ($model->yearlyLayout())
                    <input type="hidden" name="layout" value="month">
                @endif
                <input type="hidden" name="month" value="{{ $renderer->currentMonthId() }}" />
            @endif
        </x-dialog>
    </x-form>
@endsection
