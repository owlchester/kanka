<?php

namespace App\Models;

use App\Models\Scopes\CommunityVoteScopes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
 * @property Carbon $updated_at
 *
 * @property Collection $ballots
 * @property string $link
 */
class CommunityVote extends Model
{
    use CommunityVoteScopes;

    public const string STATUS_DRAFT = 'draft';
    public const string STATUS_SCHEDULED = 'scheduled';
    public const string STATUS_VOTING = 'voting';
    public const string STATUS_PUBLISHED = 'published';

    protected $cachedStatus = false;
    protected $cachedResults = false;

    public $casts = [
        'visible_at' => 'date',
        'published_at' => 'date',
    ];

    public function ballots(): HasMany
    {
        return $this->hasMany(CommunityVoteBallot::class);
    }

    /**
     * Get the vote status as a string
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
     */
    public function getSlug(): string
    {
        return $this->id . '-' . Str::slug($this->name);
    }

    /**
     * Get the options as an array expression
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
     */
    public function ballotWidth(string $option): int
    {
        return Arr::get($this->voteStats(), $option, 0);
    }

    /**
     */
    public function isVoting(): bool
    {
        return $this->status() === self::STATUS_VOTING;
    }

    /**
     * Returns if a user casted a ballot for this vote
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
                // @phpstan-ignore-next-line
                $this->cachedResults[$vote->vote] = floor(($vote->total / $totalBallots) * 100);
            }
        }
        return $this->cachedResults;
    }
}
