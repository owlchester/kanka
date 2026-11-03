<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventParticipant extends Model
{
    protected $fillable = ['entity_id', 'group_id', 'role', 'position'];

    protected $attributes = ['position' => 0];

    /** @return BelongsTo<Event, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /** @return BelongsTo<Entity, $this> */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /** @return BelongsTo<EventGroup, $this> */
    public function group(): BelongsTo
    {
        return $this->belongsTo(EventGroup::class, 'group_id');
    }
}
