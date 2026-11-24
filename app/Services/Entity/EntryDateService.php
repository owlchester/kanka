<?php

namespace App\Services\Entity;

use App\Enums\EntityEventTypes;
use App\Enums\Visibility;
use App\Models\Entity;
use App\Models\Scopes\VisibilityIDScope;
use App\Models\User;
use App\Rules\EntryDates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntryDateService
{
    public static function types(int $typeId): array
    {
        if ($typeId === (int) config('entities.ids.character')) {
            return ['birth' => EntityEventTypes::birth, 'death' => EntityEventTypes::death];
        }

        if (in_array($typeId, [config('entities.ids.family'), config('entities.ids.location'), config('entities.ids.organisation')])) {
            return ['founded' => EntityEventTypes::founded];
        }

        return [];
    }

    public static function hasDateInput(array $date): bool
    {
        return array_filter(
            array_intersect_key($date, array_flip(['year', 'month', 'day'])),
            fn ($part) => $part !== null && $part !== '',
        ) !== [];
    }

    public function save(Entity $entity, array $dates, User $user): void
    {
        DB::transaction(function () use ($entity, $dates, $user): void {
            Entity::whereKey($entity->id)->lockForUpdate()->firstOrFail();
            Validator::make(['entry_dates' => $dates], [
                'entry_dates' => [new EntryDates($entity->campaign, $entity->type_id, $entity, $user)],
            ])->validate();

            foreach (self::types($entity->type_id) as $key => $type) {
                if (! array_key_exists($key, $dates)) {
                    continue;
                }
                $date = $dates[$key];
                if (empty($date['remove']) && ! self::hasDateInput($date)) {
                    continue;
                }
                $reminder = $entity->reminders()->where('type_id', $type)->first();
                if (! empty($date['remove'])) {
                    $reminder?->delete();

                    continue;
                }
                if (empty($date['calendar_id'])) {
                    continue;
                }

                $values = array_intersect_key($date, array_flip(['calendar_id', 'year', 'month', 'day']));
                if ($reminder) {
                    $reminder->fill($values);
                    if ($reminder->isDirty(['calendar_id', 'year', 'month', 'day'])) {
                        $reminder->elapsed = null;
                        $reminder->save();
                    }
                } else {
                    $entity->reminders()->create($values + [
                        'type_id' => $type,
                        'length' => 1,
                        'visibility_id' => Visibility::All,
                        'is_recurring' => false,
                    ]);
                }
            }
            $entity->unsetRelation('elapsedEvents');
        });
    }

    public function editableReminder(Entity $entity, EntityEventTypes $type): bool
    {
        $all = $entity->reminders()->withoutGlobalScope(VisibilityIDScope::class)->where('type_id', $type)->count();
        $visible = $entity->reminders()->where('type_id', $type)->first();

        return $all === 0 || ($all === 1 && $visible && $visible->calendar?->entity && auth()->user()->can('update', $visible));
    }
}
