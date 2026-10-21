<?php

namespace App\Rules;

use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Scopes\VisibilityIDScope;
use App\Models\User;
use App\Services\Entity\EntryDateService;
use App\ValueObjects\Calendars\CalendarDate;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class EntryDates implements ValidationRule
{
    public function __construct(
        private Campaign $campaign,
        private int $typeId,
        private ?Entity $entity,
        private User $user,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $types = EntryDateService::types($this->typeId);
        if (! $this->campaign->enabled('calendars') || ! $types || ! is_array($value) || array_diff(array_keys($value), array_keys($types))) {
            $fail(__('entries/workspace.dates.unsupported'));

            return;
        }

        $validator = Validator::make(['dates' => $value], [
            'dates.*' => 'array:calendar_id,year,month,day,remove',
            'dates.*.calendar_id' => 'nullable|integer',
            'dates.*.year' => 'nullable|integer|between:-2147483648,2147483647',
            'dates.*.month' => 'nullable|integer|min:1',
            'dates.*.day' => 'nullable|integer|min:1',
            'dates.*.remove' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            $fail(__('entries/workspace.dates.invalid'));

            return;
        }

        foreach ($value as $key => $date) {
            if (empty($date['remove']) && ! EntryDateService::hasDateInput($date)) {
                continue;
            }

            if ($this->entity) {
                $all = $this->entity->reminders()->withoutGlobalScope(VisibilityIDScope::class)->where('type_id', $types[$key])->count();
                $existing = $this->entity->reminders()->where('type_id', $types[$key])->first();
                if ($all > 1 || ($all && (! $existing || ! $existing->calendar?->entity || ! $this->user->can('update', $existing)))) {
                    $fail(__('entries/workspace.dates.permission'));

                    return;
                }
            }
            if (! empty($date['remove'])) {
                continue;
            }

            $calendar = Calendar::where('campaign_id', $this->campaign->id)->with('entity')->find($date['calendar_id'] ?? null);
            if (! $calendar || ! $calendar->entity || ! $this->user->can('update', $calendar->entity)) {
                $fail(__('entries/workspace.dates.permission'));

                return;
            }
            foreach (['year', 'month', 'day'] as $part) {
                if (! isset($date[$part]) || $date[$part] === '') {
                    $fail(__('entries/workspace.dates.invalid'));

                    return;
                }
            }
            try {
                if (! $calendar->chronology()->isValid(new CalendarDate((int) $date['year'], (int) $date['month'], (int) $date['day']))) {
                    $fail(__('entries/workspace.dates.invalid'));

                    return;
                }
            } catch (InvalidArgumentException) {
                $fail(__('entries/workspace.dates.invalid'));

                return;
            }
        }

        $effective = $value;
        foreach (['birth', 'death'] as $key) {
            if (empty($effective[$key]['remove']) && ! EntryDateService::hasDateInput($effective[$key] ?? [])) {
                $effective[$key] = [];
                if (isset($types[$key]) && $this->entity) {
                    $existing = $this->entity->reminders()->where('type_id', $types[$key])->first();
                    if ($existing) {
                        $effective[$key] = $existing->only(['calendar_id', 'year', 'month', 'day']);
                    }
                }
            }
        }
        $birth = $effective['birth'] ?? [];
        $death = $effective['death'] ?? [];
        if (! empty($birth['calendar_id']) && ! empty($death['calendar_id']) && empty($birth['remove']) && empty($death['remove']) && $birth['calendar_id'] == $death['calendar_id']) {
            $birthDate = new CalendarDate((int) $birth['year'], (int) $birth['month'], (int) $birth['day']);
            $deathDate = new CalendarDate((int) $death['year'], (int) $death['month'], (int) $death['day']);
            if ($deathDate->compare($birthDate) < 0) {
                $fail(__('entries/workspace.dates.order'));
            }
        }
    }
}
