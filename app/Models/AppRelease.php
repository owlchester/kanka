<?php

namespace App\Models;

use App\Facades\UserCache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AppRelease
 *
 * @property int $id
 * @property string $name
 * @property string $excerpt
 * @property string $link
 * @property Carbon $published_at
 * @property Carbon $end_at
 * @property int $created_by
 * @property int $category_id
 * @property User $author
 */
class AppRelease extends Model
{
    public const int CATEGORY_RELEASE = 1;

    public const int CATEGORY_EVENT = 2;

    public const int CATEGORY_VOTE = 3;

    public const int CATEGORY_OTHER = 4;

    public const int CATEGORY_LIVESTREAM = 5;

    public $table = 'releases';

    public $casts = [
        'published_at' => 'date',
        'end_at' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Release's category
     */
    public function category(): string
    {
        if ($this->category_id == self::CATEGORY_RELEASE) {
            return __('releases.categories.release');
        } elseif ($this->category_id == self::CATEGORY_EVENT) {
            return __('releases.categories.event');
        } elseif ($this->category_id == self::CATEGORY_VOTE) {
            return __('releases.categories.vote');
        } elseif ($this->category_id == self::CATEGORY_OTHER) {
            return __('releases.categories.other');
        } elseif ($this->category_id == self::CATEGORY_LIVESTREAM) {
            return __('releases.categories.livestream');
        }

        return '';
    }

    /**
     * Check if the user has already read this release
     */
    public function alreadyRead(): bool
    {
        // Don't show announcements that are older than the account itself
        $firstVisibility = ! empty($this->published_at) ? $this->published_at : $this->created_at;
        if ($firstVisibility->isBefore(auth()->user()->created_at)) {
            return true;
        }

        // Check if the user has the release tutorial entry on the db.
        return UserCache::user(auth()->user())->dismissedTutorial('releases_' . $this->category_id . '_' . $this->id);
    }

    /**
     * Check if the release shouldn't be shown anymore
     */
    public function isPast(): bool
    {
        return ! empty($this->end_at) && $this->end_at->isPast();
    }
}
