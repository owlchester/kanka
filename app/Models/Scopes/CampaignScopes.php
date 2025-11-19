<?php

namespace App\Models\Scopes;

use App\Enums\CampaignVisibility;
use App\Facades\Identity;
use App\Models\Campaign;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Arr;

/**
 * Trait CampaignScopes
 *
 * @method static self|Builder visibility(int $visibility)
 * @method static self|Builder admin()
 * @method static self|Builder public()
 * @method static self|Builder top()
 * @method static self|Builder front(?string $sort = null)
 * @method static self|Builder featured(bool $featured = true)
 * @method static self|Builder filterPublic(array $filters)
 * @method static self|Builder open()
 * @method static self|Builder unboosted()
 * @method static self|Builder hidden()
 * @method static self|Builder slug(string|int $slug)
 * @method static self|Builder acl(string|int $slug)
 * @method static self|Builder userOrdered(User $user)
 */
trait CampaignScopes
{
    /**
     * We bind the campaign model on the slug in the url, so we need to ensure
     * that the user can only access valid campaigns. This means for either
     * public campaigns, or campaigns that the user is a member of.
     */
    public function scopeAcl(Builder $query, string|int $slug): Builder
    {
        if (auth()->guest()) {
            return $this->public()->slug($slug);
        }

        // If we are impersonating, that gives us only a single choice
        if (Identity::isImpersonating()) {
            return $this
                ->slug($slug)
                // Use ID and not slug to avoid shenanigans when updating the slug
                ->where($this->getTable() . '.id', Identity::getCampaignId());
        }

        // Limit to the campaigns the user is in
        return $this
            ->select($this->getTable() . '.*')
            ->leftJoin('campaign_user as cu', function (JoinClause $sub) {
                return $sub->on('cu.campaign_id', $this->getTable() . '.id')
                    ->where('cu.user_id', auth()->user()->id);
            })
            ->slug($slug)
            ->where(function ($sub) {
                return $sub
                    ->public()
                    ->orWhereNotNull('cu.user_id');
            });
    }

    /**
     * Filter on a campaign's ID or slug. Since slugs always require at least one letter,
     * we can have this is_numeric logic to differentiate between the two. We also need
     * this for the APIs, as those work on the ID and not the slug.
     */
    public function scopeSlug(Builder $query, string|int $slug): Builder
    {
        $key = is_numeric($slug) ? 'id' : 'slug';

        return $query->where($this->getTable() . '.' . $key, '=', $slug);
    }

    public function scopeVisibility(Builder $query, CampaignVisibility $visibility): Builder
    {
        return $query->where($this->getTable() . '.visibility_id', $visibility->value);
    }

    public function scopeOpen(Builder $query, bool $open = true): Builder
    {
        return $query->where('is_open', $open);
    }

    /**
     * Admin crud datagrid
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->with('users');
    }

    /**
     * Featured Campaigns
     */
    public function scopeFeatured(Builder $query, $featured = true): Builder
    {
        if ($featured) {
            return $query->where('is_featured', true)
                ->where(function ($sub) {
                    return $sub->whereNull('featured_until')
                        ->orWhereDate('featured_until', '>=', Carbon::today()->toDateString());
                });
        }

        // Not featured, or featured in the past
        return $query->where('is_featured', $featured)
            ->orWhere(function ($sub) {
                return $sub->where('is_featured', true)
                    ->whereDate('featured_until', '<', Carbon::today()->toDateString());
            });
    }

    /**
     * Public campaigns
     */
    public function scopePublic(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query->visibility(\App\Enums\CampaignVisibility::public);
    }

    /**
     * Filtered campaigns for the front end
     */
    public function scopeFront(Builder $query, ?int $sort = null): Builder
    {
        if (! config('app.debug')) {
            $query
                ->where('visible_entity_count', '>', 0);
        }
        $defaultSort = $sort == 1 ? 'follower' : 'visible_entity_count';
        $query
            ->with('systems')
            ->where('is_hidden', 0)
            ->orderBy($defaultSort, 'desc')
            ->orderBy('name');

        return $query;
    }

    public function scopeFilterPublic(Builder $query, array $options): Builder
    {
        $language = Arr::get($options, 'language');
        $genre = Arr::get($options, 'genre');
        $system = Arr::get($options, 'system');
        if (! empty($language)) {
            $query->where('locale', $language);
        }

        if (! empty($genre)) {
            $query
                ->select('campaigns.*')
                ->leftJoin('campaign_genre as cg', function ($join) {
                    $join->on('cg.campaign_id', '=', 'campaigns.id');
                })->where('cg.genre_id', $genre);
        }

        if (! empty($system)) {
            $query
                ->select('campaigns.*')
                ->leftJoin('campaign_system as cs', function ($join) {
                    $join->on('cs.campaign_id', '=', 'campaigns.id');
                })
                ->whereIn('cs.system_id', $system)
                ->distinct();
        }
        $boosted = Arr::get($options, 'is_boosted');
        if ($boosted === '1') {
            $query->where('boost_count', '>=', 1);
        } elseif ($boosted === '0') {
            $query->where(function ($sub) {
                return $sub->where('boost_count', 0)->orWhereNull('boost_count');
            });
        }

        $open = Arr::get($options, 'is_open');
        if ($open === '1') {
            $query->open(); // @phpstan-ignore-line
        } elseif ($open === '0') {
            $query->open(false); // @phpstan-ignore-line
        }

        $featured = Arr::get($options, 'featured_until');
        if ($featured === '1') {
            $query->whereNull('featured_until');
        } elseif ($featured === '0') {
            $query->whereNotNull('featured_until');
        }

        return $query;
    }

    public function scopePreparedWith(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Unboosted campaigns
     */
    public function scopeUnboosted(Builder $query): Builder
    {
        return $query->where(function ($sub) {
            return $sub->where('boost_count', 0)
                ->orWhereNull('boost_count');
        });
    }

    public function scopeHidden(Builder $query, int $hidden = 1): Builder
    {
        return $query->where(['is_hidden' => $hidden]);
    }

    public function scopeUserOrdered(Builder $query, User $user): Builder
    {
        switch ($user->campaignSwitcherOrderBy) {
            case 'alphabetical':
                $query->orderBy('name', 'asc');
                break;
            case 'r_alphabetical':
                $query->orderBy('name', 'desc');
                break;
            case 'date_joined':
                // @phpstan-ignore-next-line
                $query->orderBy('pivot_created_at', 'asc');
                break;
            case 'r_date_joined':
                // @phpstan-ignore-next-line
                $query->orderBy('pivot_created_at', 'desc');
                break;
            case 'r_date_created':
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }
}
