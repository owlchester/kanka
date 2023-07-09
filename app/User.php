<?php

namespace App;

use App\Facades\Identity;
use App\Facades\Img;
use App\Facades\PostCache;
use App\Facades\SingleUserCache;
use App\Facades\UserCache;
use App\Models\AppRelease;
use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Models\CampaignRole;
use App\Models\Concerns\Tutorial;
use App\Models\Concerns\UserBoosters;
use App\Models\Concerns\UserTokens;
use App\Models\Pledge;
use App\Models\Scopes\UserScope;
use App\Models\UserLog;
use App\Models\UserSetting;
use App\Models\Relations\UserRelations;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use App\Models\Concerns\LastSync;

/**
 * Class User
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property integer|null $last_campaign_id
 * @property string|null $avatar
 * @property string $provider
 * @property integer $provider_id
 * @property Carbon $last_login_at
 * @property integer $welcome_campaign_id
 * @property boolean $newsletter
 * @property boolean $has_last_login_sharing
 * @property string|null $pledge
 * @property string|null $timezone
 * @property string|null $currency
 * @property int $referral_id
 * @property Carbon|string|null $card_expires_at
 * @property Carbon|string|null $banned_until
 * @property Carbon|string|null $created_at
 * @property Collection|array $settings
 * @property Collection|array $profile
 * @property Campaign $campaign
 *
 * Virtual (from \App\Models\UserSetting)
 * @property bool $advancedMentions
 * @property bool $defaultNested
 * @property string $campaignSwitcherOrderBy
 *
 * @property string $stripe_id
 */
class User extends \Illuminate\Foundation\Auth\User
{
    use Billable;
    use HasApiTokens;
    use LastSync;
    use Notifiable;
    use Tutorial;
    use UserRelations;
    use UserScope;
    use UserSetting;
    use UserTokens;
    use UserBoosters;


    protected static $currentCampaign = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
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
        'locale', // Keep this for the LocaleChange middleware
        'last_login_at',
        'has_last_login_sharing',
        'pledge',
        'referral_id',
        'profile',
        'settings',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token', 'card_expires_at',
    ];

    /**
     * Casted variables
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'tutorial' => 'array',
        'profile' => 'array',
        'card_expires_at' => 'datetime',
        'last_login_at' => 'date',
        'banned_until' => 'date',
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
     * Change the current campaign (when creating a new one)
     * @param Campaign $campaign
     * @return $this
     */
    public function setCurrentCampaign(Campaign $campaign): self
    {
        self::$currentCampaign = $campaign;
        return $this;
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
     * @param int|null $campaignId
     * @return string
     */
    public function rolesList(int $campaignId = null): string
    {
        if ($campaignId === null && !empty($this->campaign)) {
            $campaignId = $this->campaign->id;
        }

        /** @var CampaignRole[] $roles */
        $roles = $this->campaignRoles->where('campaign_id', $campaignId);
        $roleLinks = [];
        foreach ($roles as $role) {
            if (auth()->user()->isAdmin()) {
                $roleLinks[] = link_to_route('campaign_roles.show', $role->name, [$role->id]);
            } else {
                $roleLinks[] = $role->name;
            }
        }
        return (string) implode(', ', $roleLinks);
    }

    public function hasCampaignRole(int $roleId)
    {
        $campaignId = $this->campaign->id;
        $roleIds = $this->campaignRoles->where('campaign_id', $campaignId)->pluck('id')->toArray();

        return in_array($roleId, $roleIds);
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
        $campaigns = UserCache::campaigns();
        return $campaigns->where('campaign_id', '<>', $campaignId)->count() > 0;
    }

    /**
     * Get max file size of user
     * @param bool $readable
     * @return string|int
     */
    public function maxUploadSize(bool $readable = false): string|int
    {
        $campaign = CampaignLocalization::getCampaign();
        if (!$this->isSubscriber() && (empty($campaign) || !$campaign->boosted())) {
            $min = config('limits.filesize.image');
            return $readable ? $min . 'MB' : ($min * 1024);
        } elseif ($this->isElemental()) {
            // Anders gets higher upload sizes until we handle this in the db.
            if ($this->id === 34122) {
                return $readable ? '100MB' : 102400;
            }
            return $readable ? '25MB' : 25600;
        } elseif ($this->isWyvern()) {
            return $readable ? '15MB' : 15360;
        }
        // Allow kobolds and goblins to have the Owlbear sizes
        return $readable ? '8MB' : 8192;
    }

    /**
     * Determine the max upload size for a map
     * @param bool $readable
     * @return string|int
     */
    public function mapUploadSize(bool $readable = false): string|int
    {
        $campaign = CampaignLocalization::getCampaign();
        // Not a subscriber and not in a boosted campaign get the default
        if (!$this->isSubscriber() && (empty($campaign) || !$campaign->boosted())) {
            return $readable ? '3MB' : 3072;
        } elseif ($this->isElemental()) {
            // Anders gets higher upload sizes until we handle this in the db.
            if ($this->id === 34122) {
                return $readable ? '100MB' : 102400;
            }
            return $readable ? '50MB' : 51200;
        } elseif ($this->isWyvern()) {
            return $readable ? '20mb' : 20480;
        }
        // We allow Kobolds and Goblins to have 10MB
        return $readable ? '10MB' : 10240;
    }

    /**
     * Determine if a user is a subscriber
     * @return bool
     */
    public function isSubscriber(): bool
    {
        return $this->hasRole(Pledge::ROLE) || $this->hasRole('admin');
    }

    /**
     * Determine if a user has a legacy patreon sync set up
     * @return bool
     */
    public function isLegacyPatron(): bool
    {
        return $this->hasRole(Pledge::ROLE) && !empty($this->patreon_email);
    }

    /**
     * Determine if a user is a goblin (deprecated)
     * @return bool
     */
    public function isGoblin(): bool
    {
        return !empty($this->pledge) && $this->pledge !== Pledge::KOBOLD;
    }

    /**
     * Determine if a user is an elemental
     * @return bool
     */
    public function isElemental(): bool
    {
        if (!empty($this->pledge) && $this->pledge == Pledge::ELEMENTAL) {
            return true;
        }
        // We check the campaign and roles for 61105 because of a special Elemental subscriber.
        $campaign = CampaignLocalization::getCampaign(false);
        return (!empty($campaign) && $this->campaignRoles->where('campaign_id', $campaign->id)->where('id', '61105')->count() == 1);
    }

    /**
     * @return bool
     */
    public function isOwlbear(): bool
    {
        return !empty($this->pledge) && $this->pledge == Pledge::OWLBEAR;
    }

    /**
     * @return bool
     */
    public function isWyvern(): bool
    {
        return !empty($this->pledge) && $this->pledge == Pledge::WYVERN;
    }

    /**
     * API throttling is increased for subscribers
     * @return int
     */
    public function getRateLimitAttribute(): int
    {
        return $this->isGoblin() ? 90 : 30;
    }

    /**
     * Currency symbol
     * @return string
     */
    public function currencySymbol(): string
    {
        if ($this->billedInEur()) {
            return '€';
        }
        return 'US$';
    }

    /**
     * Determine if the user is billed in EUR.
     * @return bool
     */
    public function billedInEur(): bool
    {
        return $this->currency() === 'eur';
    }

    /**
     * Determine if ads should be shown for the user or campaign
     * @return bool
     */
    public function showAds(): bool
    {
        // Patrons and subs don't have ads
        if ($this->isSubscriber()) {
            return false;
        }

        // Campaigns that are boosted don't either
        $campaign = CampaignLocalization::getCampaign(false);
        return !empty($campaign) && !$campaign->boosted();
    }

    /**
     * @return array
     */
    public function adminCampaigns(): array
    {
        $campaigns = [];

        $roles = $this
            ->campaignRoles()
            ->where('campaign_roles.is_admin', 1)->with('campaign')
            ->get();
        foreach ($roles as $role) {
            $campaigns[$role->campaign->id] = $role->campaign->name;
        }

        return $campaigns;
    }

    /**
     * Check if User has a Role(s) associated.
     *
     * @param string|array $name The role(s) to check.
     *
     * @return bool
     */
    public function hasRole($name): bool
    {
        $roles = $this->roles->pluck('name')->toArray();

        foreach ((is_array($name) ? $name : [$name]) as $role) {
            if (in_array($role, $roles)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a user is using a social login
     * @return bool
     */
    public function isSocialLogin(): bool
    {
        return !empty($this->provider);
    }

    /**
     * Number of entities the user has created
     * @return string
     */
    public function createdEntitiesCount(): string
    {
        return (string) number_format(SingleUserCache::user($this)->entitiesCreatedCount());
    }

    public function hasPlugins(): bool
    {
        return config('marketplace.enabled') && $this->plugins->count();
    }

    /**
     * Get the Discord app of the user
     * @return mixed
     */
    public function discord()
    {
        return $this->apps->where('app', 'discord')->first();
    }

    /**
     * Get the user's role IDs based on the campaign
     * @param int $campaignID
     * @return array
     */
    public function campaignRoleIDs(int $campaignID): array
    {
        $roles = UserCache::roles()->where('campaign_id', $campaignID);
        return $roles->pluck('id')->toArray();
    }

    /**
     * Log an event on the user
     * @param int $type
     * @return $this
     */
    public function log(int $type): self
    {
        UserLog::create([
            'user_id' => $this->id,
            'type_id' => $type,
        ]);
        return $this;
    }

    /**
     * Determine if the user is banned
     * @return bool
     */
    public function isBanned(): bool
    {
        return !empty($this->banned_until) && $this->banned_until->isFuture();
    }

    /**
     * Determine if the user has achievements to display on their profile page
     * @return bool
     */
    public function hasAchievements(): bool
    {
        return $this->isWordsmith();
    }

    /**
     * Determine if a user has the Wordsmith role
     * @return bool
     */
    public function isWordsmith(): bool
    {
        return $this->hasRole('wordsmith');
    }

    /**
     * Check if user has 2FA.
     */
    public function passwordSecurity()
    {
        return $this->hasOne('App\Models\PasswordSecurity');
    }

    public function initials(): string
    {
        if (!Str::contains(' ', $this->name)) {
            return Str::limit($this->name, 2, '');
        }
        $explode = explode(' ', $this->name);
        return $explode[0] . $explode[1];
    }

    /**
     * Determine if the user has unread notifications or kanka alerts
     * @return bool
     */
    public function hasUnread(): bool
    {
        if (Identity::isImpersonating()) {
            return false;
        }

        // Unread notifications
        $releases = PostCache::latest();
        /** @var AppRelease $release */
        foreach ($releases as $release) {
            if (!$release->alreadyRead()) {
                return true;
            }
        }

        return $this->unreadNotifications()->count() > 0;
    }

    /**
     * Fraud detection system
     * @return bool
     */
    public function isFrauding(): bool
    {
        // Fraud detection can be turned on or off
        if (!config('subscription.fraud_detection')) {
            return false;
        }
        // Someone with a provider (twitter, fb) login is always considered safe
        if (!empty($this->provider)) {
            return false;
        }
        // If the account was created recently, add some small checks
        if ($this->created_at->isAfter(Carbon::now()->subHour())) {
            // User's name is directly in the campaign name
            if (Str::startsWith($this->email, $this->name . '@')) {
                return true;
            } elseif ($this->campaigns()->count() === 1) {
                $campaign = $this->campaigns()->first();
                // Only the 4 starting entities
                // @phpstan-ignore-next-line
                if ($campaign->entities()->withInvisible()->count() === 4) {
                    return true;
                }
            }
        }
        // Recent fails are a clear indicator of someone cycling through cards
        return $this->logs()
            ->where('type_id', UserLog::TYPE_FAILED_CHARGE_EMAIL)
            ->whereDate('created_at', '>=', Carbon::now()->subHour()->toDateString())
            ->count() >= 2;
    }
}
