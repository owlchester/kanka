<?php

namespace App;

use App\Facades\Img;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Models\Concerns\Filterable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Patreon;
use App\Models\Relations\UserRelations;
use App\Models\Scopes\UserScope;
use App\Models\UserSetting;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property integer $last_campaign_id
 * @property string $avatar
 * @property string $provider
 * @property integer $provider_id
 * @property string $last_login_at
 * @property integer $welcome_campaign_id
 * @property boolean $newsletter
 * @property boolean $has_last_login_sharing
 * @property string $patreon_pledge
 * @property int $booster_count
 * @property int $referral_id
 *
 * Virtual
 * @property bool $advancedMentions
 * @property bool $defaultNested
 * @property string $patreon_fullname
 * @property string $patreon_email
 */
class User extends \TCG\Voyager\Models\User
{
    use Notifiable,
        HasApiTokens,
        UserScope,
        UserRelations,
        UserSetting,
        Searchable,
        Filterable,
        Sortable,
        Billable;

    protected static $currentCampaign = false;

    public $additional_attributes = [
        'patreon_fullname',
        //'patreon_email'
    ];

    public $searchableColumns = ['email', 'settings'];
    public $sortableColumns = [];
    public $filterableColumns = ['patreon_pledge', 'referral_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_campaign_id',
        'provider',
        'provider_id',
        'newsletter',
        'timezone',
        'campaign_role',
        'theme',
        'date_format',
        'default_pagination',
        'locale', // Keep this for the LocaleChange middleware
        'last_login_at',
        'has_last_login_sharing',
        'patreon_pledge',
        'referral_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login_at',
    ];

    /**
     * Get the user's campaign.
     * This is the equivalent of calling user->campaign or user->getCampaign
     * @return Campaign|null
     */
    public function getCampaignAttribute()
    {
        // We use a dirty static system because relying on the last_campaign_id doesn't work when two sessions
        // are active form the same user.
        if (self::$currentCampaign === false) {
            self::$currentCampaign = CampaignLocalization::getCampaign();
        }
        return self::$currentCampaign;
    }



    /**
     * Get the other campaigns of the user
     * @param bool $hasEmpty
     * @return array
     */
    public function moveCampaignList(bool $hasEmpty = true): array
    {
        $campaigns = $hasEmpty ? [0 => ''] : [];
        foreach ($this->campaigns()->whereNotIn('campaign_id', [$this->campaign->id])->get() as $campaign) {
            $campaigns[$campaign->id] = $campaign->name;
        }
        return $campaigns;
    }

    /**
     * @param int $size = 40
     * @return string
     */
    public function getAvatarUrl(int $size = 40): string
    {
        if (!empty($this->avatar) && $this->avatar != 'users/default.png') {
            return Img::crop($size, $size)->url($this->avatar);
        } else {
            return '/images/defaults/user.svg';
        }
    }

    /**
     * @param null $campaignId
     * @return mixed
     */
    public function rolesList($campaignId = null)
    {
        if (empty($campaignId) && !empty($this->campaign)) {
            $campaignId = $this->campaign->id;
        }
        $roles = $this->campaignRoles->where('campaign_id', $campaignId);
        return $roles->implode('name', ', ');
    }

    /**
     * Figure out if the user is an admin of the current campaign
     */
    public function isAdmin(): bool
    {
        return UserCache::user($this)->campaign($this->campaign)->admin();
    }

    /**
     * Check if a user has campaigns
     * @return bool
     */
    public function hasCampaigns($count = 0): bool
    {
        return UserCache::user($this)->campaigns()->count() > $count;
    }

    /**
     * Check if the user has other campaigns than the current one
     * @param int $campaignId
     * @return bool
     */
    public function hasOtherCampaigns(int $campaignId): bool
    {
        return $this->campaigns()->where('campaign_id', '!=', $campaignId)->count() > 0;
    }

    /**
     * Get the user's avatar
     * @return string
     */
    public function getAvatar()
    {
        return "<span class=\"entity-image\" style=\"background-image: url('" .
            $this->getAvatarUrl(40) . "');\" title=\"" . e($this->name) . "\"></span>";
    }


    /**
     * Get max file size of user
     * @param bool $readable
     * @return int|string
     */
    public function maxUploadSize($readable = false, $what = 'image')
    {
        $campaign = CampaignLocalization::getCampaign();
        if ($this->isPatron() || ($campaign && $campaign->boosted())) {
            // Elementals get massive upload sizes
            if ($this->isElementalPatreon()) {
                return $readable ? '25MB' : 25600;
            }
            elseif ($what == 'map') {
                return $readable ? '10MB' : 10240;
            }
            return $readable ? '8MB' : 8192;
        }
        elseif ($what == 'map') {
            return $readable ? '3MB' : 3072;
        }
        return $readable ? '1MB' : 2048;
    }

    /**
     * Determine if a user is a patron
     * @return bool
     */
    public function isPatron(): bool
    {
        return $this->hasRole('patreon') || $this->hasRole('admin');
    }

    /**
     * Determine if a user has a patreon-synced set up
     * @return bool
     */
    public function hasPatreonSync(): bool
    {
        return $this->hasRole('patreon') && !empty($this->patreon_email);
    }

    /**
     * Determine if a user is a goblin (deprecated)
     * @return bool
     */
    public function isGoblinPatron(): bool
    {
        return ($this->hasRole('patreon') && !empty($this->patreon_pledge)
                && $this->patreon_pledge != Patreon::PLEDGE_KOBOLD)
           || $this->hasRole('admin')
        ;
    }

    /**
     * Determine if a user is an elemental
     * @return bool
     */
    public function isElementalPatreon(): bool
    {
        $campaign = CampaignLocalization::getCampaign();
        return (!empty($this->patreon_pledge) && $this->patreon_pledge == Patreon::PLEDGE_ELEMENTAL) ||
            (!empty($campaign) && $this->campaignRoles->where('campaign_id', $campaign->id)->where('id', '61105')->count() == 1);
    }

    /**
     * @return bool
     */
    public function isOwlbear(): bool
    {
        return !empty($this->patreon_pledge) && $this->patreon_pledge == Patreon::PLEDGE_OWLBEAR;
    }



    /**
     * Get available boosts for the user
     * @return int
     */
    public function availableBoosts(): int
    {
        return $this->maxBoosts() - $this->boosting();
    }

    /**
     * Get amount of campaigns the user is boosting
     * @return int
     */
    public function boosting(): int
    {
        return $this->boosts->count();
    }

    /**
     * Get max number of boosts a user can give
     * @return int
     */
    public function maxBoosts(): int
    {
        // Allows us to give boosters to members of the community
        if (!empty($this->booster_count)) {
            return $this->booster_count;
        }

        if (!$this->isPatron()) {
            return 0;
        }

        if ($this->hasRole('admin')) {
            return 3;
        }

        $levels = [
            Patreon::PLEDGE_KOBOLD => 0,
            Patreon::PLEDGE_GOBLIN => 1,
            Patreon::PLEDGE_OWLBEAR => 3,
            Patreon::PLEDGE_ELEMENTAL => 10,
        ];

        // Default 3 for admins and owlbears
        return Arr::get($levels, $this->patreon_pledge, 0);
    }

    /**
     * API throttling is increased for patrons
     * @return int
     */
    public function getRateLimitAttribute(): int
    {
        return $this->isGoblinPatron() ? 90 : 30;
    }

    /**
     * Currency symbol
     * @return string
     */
    public function currencySymbol(): string
    {
        if ($this->currency === 'eur') {
            return '€';
        }
        return 'US$';
    }
}
