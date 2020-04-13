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
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

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
 *
 * @property Collection $ballots
 * @property string $link
 */
class CommunityVote extends Model implements Feedable
{
    use Filterable, Sortable, Searchable, CommunityVoteScopes;

    const STATUS_DRAFT = 'draft';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_VOTING = 'voting';
    const STATUS_PUBLISHED = 'published';

    public $searchableColumns = ['name'];
    public $sortableColumns = [];
    public $filterableColumns = ['name'];

    protected $cachedStatus = false;
    protected $cachedResults = false;

    public $dates = [
        'visible_at',
        'published_at'
    ];

    public $fillable = [
        'name',
        'content',
        'excerpt',
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
        if ($this->cachedStatus === false) {
            if (empty($this->visible_at)) {
                $this->cachedStatus = self::STATUS_DRAFT;
            } elseif ($this->visible_at->isFuture()) {
                $this->cachedStatus = self::STATUS_SCHEDULED;
            } elseif (empty($this->published_at) || $this->published_at->isFuture()) {
                $this->cachedStatus = self::STATUS_VOTING;
            } else {
                $this->cachedStatus = self::STATUS_PUBLISHED;
            }
        }

        return $this->cachedStatus;
    }


    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->id . '-' . Str::slug($this->name);
    }

    /**
     * Get the options as an array expression
     * @return array
     */
    public function options(): array
    {
        if (empty($this->options)) {
            return [];
        }

        $options = json_decode($this->options, true);
        if (is_array($options)) {
            return $options;
        }

        return [];
    }

    /**
     * @return int
     */
    public function ballotWidth(string $option): int
    {
        return Arr::get($this->voteStats(), $option, 0);
    }

    /**
     * @return bool
     */
    public function isVoting(): bool
    {
        return $this->status() === self::STATUS_VOTING;
    }

    /**
     * Returns if a user casted a ballot for this vote
     * @return bool
     */
    public function votedFor(string $option): bool
    {
        if (Auth::guest()) {
            return false;
        }

        $user = Auth::user();
        return $this->ballots->contains(function ($ballot) use ($user, $option) {
            return $ballot->user_id === $user->id && $ballot->vote === $option;
        });
    }

    /**
     * @return array
     */
    public function voteStats(): array
    {
        if ($this->cachedResults === false) {
            // Prepare null results
            $this->cachedResults = [];
            foreach ($this->options() as $key => $name) {
                $this->cachedResults[$key] = 0;
            }

            $totalBallots = $this->ballots->count();
            $votes = $this->ballots()->groupBy('vote')->select('vote', \DB::raw('count(*) as total'))->get();

            foreach ($votes as $vote) {
                $this->cachedResults[$vote->vote] = floor(($vote->total / $totalBallots) * 100);
            }
        }
        return $this->cachedResults;
    }

    /**
     * RSS feed item
     * @return FeedItem
     */
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->name)
            ->summary($this->excerpt)
            ->updated($this->updated_at)
            ->link($this->link)
            ->author('Kanka.io');
    }

    /**
     * link attribute
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('community-votes.show', $this);
    }

    /**
     * RSS items
     * @return mixed
     */
    public function getFeedItems()
    {
        return CommunityVote::visible()->orderBy('published_at', 'DESC')->get();
    }
}
