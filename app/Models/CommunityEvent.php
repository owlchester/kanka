<?php

namespace App\Models;

use App\Facades\Img;
use App\Models\Scopes\CommunityEventScopes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class CommunityEvent
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $entry
 * @property string $excerpt
 * @property string $image
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property CommunityEventEntry[]|Collection $entries
 * @property CommunityEventEntry[]|Collection $rankedResults
 * @property User $jury
 */
class CommunityEvent extends Model
{
    use CommunityEventScopes;
    use HasUuids;

    public $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    /**
     * Determine if the event can be participated in
     */
    public function isOngoing(): bool
    {
        return $this->start_at->isPast() && $this->end_at->isFuture();
    }

    /**
     * Determine if the event is in the future
     */
    public function isScheduled(): bool
    {
        return $this->start_at->isFuture();
    }

    /**
     * Get the image (or default image) of an entity
     */
    public function thumbnail(int $width = 400, ?int $height = null, string $field = 'image'): string
    {
        if (empty($this->$field)) {
            return '';
        }

        return Img::crop($width, (! empty($height) ? $height : $width))->url($this->$field);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CommunityEventEntry, $this>
     */
    public function entries(): HasMany
    {
        return $this->hasMany(CommunityEventEntry::class);
    }

    public function getSlug(): string
    {
        return $this->uuid . '-' . Str::slug($this->name);
    }

    /**
     * @return Model|HasMany|object|null
     */
    public function userEntry(int $userId)
    {
        return $this->entries()->where('created_by', $userId)->first();
    }

    public function rankedResults()
    {
        return $this->entries()
            ->with('user')
            ->has('user')
            ->where(function ($rank) {
                // MySQL is weird where != -1 means that null gets also caught?
                return $rank
                    ->whereNull('rank')
                    ->orWhere('rank', '<>', -1);
            })
            ->orderByRaw('-rank desc');
    }

    /**
     * Determine if the event is finished & has a winner
     */
    public function hasRankedResults(): bool
    {
        return ! $this->rankedResults->where('rank', 1)->isEmpty();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
    public function jury(): BelongsTo
    {
        return $this->belongsTo(User::class, 'jury_id');
    }
}
