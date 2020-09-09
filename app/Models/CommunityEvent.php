<?php


namespace App\Models;


use App\Facades\Img;
use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\Uuid;
use App\Models\Scopes\CommunityEventScopes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class CommunityEvent
 * @package App\Models
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $entry
 * @property string $excerpt
 * @property string $image
 * @property Carbon $start_at
 * @property Carbon $end_at
 *
 * @property CommunityEventEntry[] $entries
 * @property CommunityEventEntry[] $rankedResults
 */
class CommunityEvent extends Model
{
    use Filterable, Sortable, Searchable, CommunityEventScopes, Uuid;

    public $searchableColumns = ['name'];
    public $sortableColumns = [];
    public $filterableColumns = ['name'];

    public $dates = [
        'start_at',
        'end_at'
    ];

    public $fillable = [
        'name',
        'entry',
        'excerpt',
        'start_at',
        'end_at',
    ];

    /**
     * Event status
     * @return string
     */
    public function status(): string
    {
        if ($this->start_at->isFuture()) {
            return __('admin/community-events.status.upcoming');
        } elseif ($this->end_at->isPast()) {
            return __('admin/community-events.status.finished');
        }
        return __('admin/community-events.status.ongoing');
    }

    /**
     * @return bool
     */
    public function isOngoing(): bool
    {
        return $this->start_at->isPast() && $this->end_at->isFuture();
    }

    /**
     * Get the image (or default image) of an entity
     * @param int $width = 200
     * @param int $width = null
     * @param string $field = 'image'
     * @return string
     */
    public function getImageUrl(int $width = 400, int $height = null, string $field = 'image')
    {
        if (empty($this->$field)) {
            return null;
        }
        return Img::crop($width, (!empty($height) ? $height : $width))->url($this->$field);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(CommunityEventEntry::class);
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->uuid . '-' . Str::slug($this->name);
    }

    /**
     * @param int $userId
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function userEntry(int $userId)
    {
        return $this->entries()->where('created_by', $userId)->first();
    }

    public function rankedResults()
    {
        return $this->entries()->with('user')->whereNotNull('rank')->orderBy('rank');
    }

    public function hasRankedResults(): bool
    {
        return !$this->rankedResults->isEmpty();
    }

}
