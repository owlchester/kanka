<?php

namespace App\Services\Calendars;

use App\Models\Calendar;
use App\Models\Reminder;
use Illuminate\Support\Collection;

class ReminderService
{
    protected Calendar $calendar;

    public function calendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Look at events to calculate the most upcoming events for the calendar
     * dashboard widget.
     */
    public function upcoming(int $needle = 10): Collection
    {
        // @phpstan-ignore-next-line
        $reminders = $this->calendar->calendarEvents()
            ->with(['remindable', 'calendar'])
            ->whereHas('remindable')
            ->where(function ($primary) {
                $primary->where(function ($sub) {
                    $sub->where(function ($recurring) {
                        $recurring
                            ->where('is_recurring', true)
                            ->whereIn('recurring_periodicity', ['year', 'month'])
                            ->where(function ($recurringuntil) {
                                $recurringuntil
                                    ->whereNull('recurring_until')
                                    // Events that end in the future are fine, they could be reoccurring on this month
                                    ->orWhere('recurring_until', '>=', $this->calendar->currentYear());
                            });
                    });
                })
                    ->orWhere(function ($ondate) {
                        // Not recurring
                        $ondate
                            ->where('is_recurring', false)
                            ->where(function ($date) {
                                // An event that happens before this year
                                $date
                                    ->where('year', '>', $this->calendar->currentYear())
                                    ->orWhere(function ($subdate) {
                                        // An event that happens this year but after this month
                                        $subdate
                                            ->where('year', $this->calendar->currentYear())
                                            ->where('month', '>', $this->calendar->currentMonth());
                                    })
                                    ->orWhere(function ($subdate) {
                                        // An event that happens this year after this year
                                        $subdate
                                            ->where('year', $this->calendar->currentYear())
                                            ->where('month', $this->calendar->currentMonth())
                                            ->where('day', '>=', $this->calendar->currentDay());
                                    });
                            });
                    });
            })
            // Skip events that were on months which no longer exist
            ->where('month', '<=', count($this->calendar->months()))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->orderBy('day', 'asc')
            ->take($needle)
            ->get();

        // Order the past events in descending date to get the closest ones to the current date first
        return $reminders->sortBy(function (Reminder $reminder) {
            return $reminder->nextUpcomingOccurrence(
                $this->calendar->currentYear(),
                $this->calendar->currentMonth(),
                $this->calendar->currentDay(),
                $this->calendar->months(),
                $this->calendar->daysInYear()
            );
        });
    }

    /**
     * Look at events to calculate the most recently occurring events for the calendar
     * dashboard widget.
     */
    public function past(int $needle = 10): Collection
    {
        // @phpstan-ignore-next-line
        $reminders = $this->calendar->calendarEvents()
            ->with(['remindable', 'calendar'])
            ->whereHas('remindable')
            ->where(function ($primary) {
                $primary->where(function ($sub) {
                    $sub->where(function ($recurring) {
                        $recurring
                            ->where('is_recurring', true)
                            ->whereIn('recurring_periodicity', ['year', 'month'])
                            ->where(function ($recurringuntil) {
                                $recurringuntil
                                    ->whereNull('recurring_until')
                                    // Events that end in the future are fine, they could be reoccurring on this month
                                    ->orWhere('recurring_until', '>=', $this->calendar->currentYear());
                            })
                            ->where('year', '<=', $this->calendar->currentYear());
                    });
                })
                    ->orWhere(function ($ondate) {
                        // Not recurring
                        $ondate
                            ->where('is_recurring', false)
                            ->where(function ($date) {
                                // An event that happens before this year
                                $date
                                    ->where('year', '<', $this->calendar->currentYear())
                                    ->orWhere(function ($subdate) {
                                        // An event that happens this year but before this month
                                        $subdate
                                            ->where('year', $this->calendar->currentYear())
                                            ->where('month', '<', $this->calendar->currentMonth());
                                    })
                                    ->orWhere(function ($subdate) {
                                        // An event that happens this year but before this day
                                        $subdate
                                            ->where('year', $this->calendar->currentYear())
                                            ->where('month', $this->calendar->currentMonth())
                                            ->where('day', '<', $this->calendar->currentDay());
                                    });
                            });
                    });
            })
            // Skip events that were on months which no longer exist
            ->where('month', '<=', count($this->calendar->months()))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc')
            ->take($needle)
            ->get();

        // Order the past events in descending date to get the closest ones to the current date first
        return $reminders->sortBy(function (Reminder $reminder) {
            return $reminder->mostRecentOccurrence(
                $this->calendar->currentYear(),
                $this->calendar->currentMonth(),
                $this->calendar->currentDay(),
                $this->calendar->months(),
                $this->calendar->daysInYear()
            );
        });
    }
}
