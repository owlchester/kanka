<?php

namespace App\Models;

use App\Enums\EntityEventTypes;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Event
 *
 * @property string $date
 */
class Event extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use Sanitizable;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'date',
        'is_private',
    ];

    protected array $sortable = [
        'name',
        'date',
        'calendar_date',
        'type',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'date',
        'calendar_date',
    ];

    public function scopeCustomSortCalendar_date(Builder $query, string $order): Builder
    {
        return $query
            ->select('events.*')
            ->leftJoin('entities as event_entity_order', function ($join) {
                $join->on('event_entity_order.entity_id', '=', 'events.id')
                    ->where('event_entity_order.type_id', config('entities.ids.event'));
            })
            ->leftJoin('reminders as event_calendar_order', function ($join) {
                $join->on('event_calendar_order.remindable_id', '=', 'event_entity_order.id')
                    ->where('event_calendar_order.remindable_type', Entity::class)
                    ->where('event_calendar_order.type_id', EntityEventTypes::calendarDate);
            })
            ->orderBy('event_calendar_order.year', $order)
            ->orderBy('event_calendar_order.month', $order)
            ->orderBy('event_calendar_order.day', $order);
    }

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
    ];

    protected array $exportFields = [
        'base',
        'date',
    ];

    protected array $sanitizable = [
        'name',
        'date',
    ];

    /** @return HasMany<EventGroup, $this> */
    public function groups(): HasMany
    {
        return $this->hasMany(EventGroup::class)->orderBy('position')->orderByDesc('id');
    }

    /** @return HasMany<EventParticipant, $this> */
    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class)->orderBy('position')->orderByDesc('id');
    }

    /** Detach event-local data when the event is moved to another campaign. */
    public function detach(): void
    {
        $this->groups()->delete();
        $this->participants()->delete();
    }

    public function scopeFilteredEvents(Builder $query): Builder
    {
        return $query
            ->select(['events.id', 'events.date', 'events.is_private'])
            ->sort(request()->only(['o', 'k']), ['entities.name' => 'asc']) // @phpstan-ignore method.notFound
            ->with([
                'entity.locations',
                'entity.calendarDate.calendar.entity',
                'entity.locations.entity' => fn ($sub) => $sub->grid(),
                'entity' => fn ($sub) => $sub->grid(),
                'entity.parent' => fn ($sub) => $sub->grid(),
                'entity.tags',
                'entity.tags.entity' => fn ($sub) => $sub->grid(),
                'entity.image'])
            ->has('entity');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.event');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->type)) {
            return true;
        }

        if (($this->relationLoaded('groups') && $this->groups->isNotEmpty()) || ($this->relationLoaded('participants') && $this->participants->isNotEmpty())) {
            return true;
        }

        if ($this->entity->locations->isNotEmpty() || ! empty($this->entity->calendarReminder())) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'date',
            'locations',
            'participants',
        ];
    }
}
