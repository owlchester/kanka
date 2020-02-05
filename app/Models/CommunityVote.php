<?php
/**
 * Description of
 */

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Scopes\CommunityVoteScopes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class CommunityVote
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $excerpt
 * @property string $options
 * @property Carbon $published_at
 * @property Carbon $visible_at
 * @property CommunityVote[] $ballots
 */
class CommunityVote extends Model
{
    use Filterable, Sortable, Searchable, CommunityVoteScopes;

    const STATUS_DRAFT = 'draft';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_VOTING = 'voting';
    const STATUS_PUBLISHED = 'published';

    public $searchableColumns = ['name'];
    public $sortableColumns = [];
    public $filterableColumns = ['name'];

    public $dates = [
        'visible_at',
        'published_at'
    ];

    public $fillable = [
        'name',
        'content',
        'options',
        'published_at',
        'visible_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ballots()
    {
        return $this->hasMany(CommunityVoteBallot::class);
    }

    /**
     * Get the vote status as a string
     * @return string
     */
    public function status(): string
    {
        if (empty($this->visible_at)) {
            return self::STATUS_DRAFT;
        } elseif ($this->visible_at->isFuture()) {
            return self::STATUS_SCHEDULED;
        } elseif (empty($this->published_at) || $this->published_at->isFuture()) {
            return self::STATUS_VOTING;
        }
        return self::STATUS_PUBLISHED;
    }


    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->id . '-' . Str::slug($this->name);
    }
}
