<?php

namespace App\Models;

use App\Enums\UserAction;
use App\Facades\CampaignLocalization;
use App\Facades\Identity;
use App\Facades\ReleaseCache;
use App\Facades\SingleUserCache;
use App\Models\Concerns\HasImage;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\UserBoosters;
use App\Models\Concerns\UserTokens;
use App\Models\Relations\UserRelations;
use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $locale
 * @property ?int $last_campaign_id
 * @property ?string $avatar
 * @property string $provider
 * @property int $provider_id
 * @property Carbon $last_login_at
 * @property int $welcome_campaign_id
 * @property bool|int $newsletter
 * @property bool|int $has_last_login_sharing
 * @property ?string $pledge
 * @property ?string $timezone
 * @property ?string $currency
 * @property int $referral_id
 * @property ?Carbon $card_expires_at
 * @property ?Carbon $banned_until
 * @property ?Carbon $created_at
 * @property Collection|array $settings
 * @property Collection|array $profile
 * @property Campaign $campaign
 * @property ?string $stripe_id
 */
class User extends \Illuminate\Foundation\Auth\User implements \Laravel\Passport\Contracts\OAuthenticatable
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasImage;
    use LastSync;
    use Notifiable;
    use UserBoosters;
    use UserRelations;
    use UserScope;
    use UserSetting;
    use UserTokens;

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
     */
    protected $hidden = [
        'password', 'remember_token', 'card_expires_at',
    ];

    /**
     * Casted variables
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'profile' => 'array',
        'card_expires_at' => 'datetime',
        'last_login_at' => 'date',
        'banned_until' => 'date',
        'trial_ends_at' => 'date',
    ];

    protected array $imageFields = ['avatar'];

    protected bool $isAdmin;

    public function getAvatarUrl(int $size = 40): string
    {
        if ($this->hasAvatar()) {
            return $this->thumbnail($size, null, 'avatar');
        } else {
            return '/images/defaults/user.svg';
        }
    }

    public function hasAvatar(): bool
    {
        return ! empty($this->avatar) && $this->avatar != 'users/default.png';
    }

    /**
     * Determine if a user has a specific role
     */
    public function hasCampaignRole(int $roleId): bool
    {
        return $this->campaignRoles->where('id', $roleId)->count() > 0;
    }

    /**
     * Figure out if the user is an admin of the current campaign.
     * $campaign can be provided, for example when listing a user's campaigns
     */
    public function isAdmin(?Campaign $campaign = null): bool
    {
        if (isset($this->isAdmin)) {
            return $this->isAdmin;
        }
        if (empty($campaign) && CampaignLocalization::hasCampaign()) {
            $campaign = CampaignLocalization::getCampaign();
        }
        if (empty($campaign)) {
            return false;
        }

        return $this->isAdmin = $this->campaignRoles
            ->where('campaign_id', $campaign->id)
            ->where('is_admin', 1)
            ->count() === 1;
    }

    /**
     * Determine if a user is a subscriber
     */
    public function isSubscriber(): bool
    {
        return $this->hasRole(Pledge::ROLE) || $this->hasRole('admin') || $this->onTrial();
    }

    /**
     * Determine if a user has a legacy patreon sync set up
     */
    public function isLegacyPatron(): bool
    {
        return $this->hasRole(Pledge::ROLE) && ! empty($this->patreon_email);
    }

    /**
     * Determine if a user is a goblin (deprecated)
     */
    public function isGoblin(): bool
    {
        return ! empty($this->pledge) && $this->pledge !== Pledge::KOBOLD;
    }

    /**
     * Determine if a user is an elemental
     */
    public function isElemental(): bool
    {
        return (bool) (! empty($this->pledge) && $this->pledge == Pledge::ELEMENTAL);
    }

    public function isOwlbear(): bool
    {
        return ! empty($this->pledge) && $this->pledge == Pledge::OWLBEAR;
    }

    public function isWyvern(): bool
    {
        return ! empty($this->pledge) && $this->pledge == Pledge::WYVERN;
    }

    /**
     * API throttling is increased for subscribers
     */
    public function getRateLimitAttribute(): int
    {
        return $this->isGoblin() ? config('limits.api.throttle.subscriber') : config('limits.api.throttle.default');
    }

    /**
     * Currency symbol
     */
    public function currencySymbol(): string
    {
        if ($this->billedInEur()) {
            return '€';
        } elseif ($this->billedInBrl()) {
            return 'R$';
        }

        return 'US$';
    }

    /**
     * Determine if the user is billed in EUR.
     */
    public function billedInEur(): bool
    {
        return $this->currency() === 'eur';
    }

    /**
     * Determine if the user is billed in BRL
     */
    public function billedInBrl(): bool
    {
        return $this->currency() === 'brl';
    }

    /**
     * Check if the user has a Role(s) associated.
     *
     * @param  string|array  $name  The role(s) to check.
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
     */
    public function isSocialLogin(): bool
    {
        return ! empty($this->provider);
    }

    /**
     * Number of entities the user has created
     */
    public function createdEntitiesCount(): string
    {
        return (string) number_format(SingleUserCache::user($this)->entitiesCreatedCount());
    }

    /**
     * Determine if the user has published plugins on the marketplace
     */
    public function hasPlugins(): bool
    {
        return config('marketplace.enabled') && $this->plugins->count();
    }

    /**
     * Get the Discord app of the user
     */
    public function discord()
    {
        return $this->apps->where('app', 'discord')->first();
    }

    /**
     * Log an event on the user
     */
    public function log(UserAction $action, array $data = []): self
    {
        // todo: move to a facade
        if (! config('logging.enabled')) {
            return $this;
        }
        $log = new UserLog([
            'user_id' => $this->id,
        ]);
        $log->type_id = $action;
        $log->data = ! empty($data) ? $data : null;
        $log->save();

        return $this;
    }

    public function campaignLog(int $campaign, string $module, string $action, array $data = []): self
    {
        // todo: move to a facade
        if (! config('logging.enabled')) {
            return $this;
        }
        $log = new UserLog([
            'user_id' => $this->id,
        ]);
        $log->type_id = UserAction::campaign;
        $log->campaign_id = $campaign;
        $first = [];
        $first['module'] = $module;
        $first['action'] = $action;
        $log->data = $first + $data;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->save();

        return $this;
    }

    /**
     * Determine if the user is banned
     */
    public function isBanned(): bool
    {
        return ! empty($this->banned_until) && $this->banned_until->isFuture();
    }

    /**
     * Determine if the user has achievements to display on their profile page
     */
    public function hasAchievements(): bool
    {
        return $this->isWordsmith();
    }

    /**
     * Determine if a user has the Wordsmith role
     */
    public function isWordsmith(): bool
    {
        return $this->hasRole('wordsmith');
    }

    /**
     * Check if user has 2FA.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\PasswordSecurity, $this>
     */
    public function passwordSecurity(): HasOne
    {
        return $this->hasOne('App\Models\PasswordSecurity');
    }

    /**
     * When auto-login is enabled, the code to check if the user needs to input their 2FA code checks for this property
     */
    public function getGoogle2faSecretAttribute(): ?string
    {
        return $this->passwordSecurity?->google2fa_secret;
    }

    /**
     * Get the user's initial for some UI elements
     */
    public function initials(): string
    {
        // If the username has no spaces, use the two first letters of the name
        if (! Str::contains(' ', $this->name)) {
            return Str::limit($this->name, 2, '');
        }
        $explode = explode(' ', $this->name);

        return $explode[0] . $explode[1];
    }

    /**
     * Determine if the user has unread notifications or kanka alerts
     */
    public function hasUnread(): bool
    {
        if (Identity::isImpersonating()) {
            return false;
        }

        // Unread notifications
        $releases = ReleaseCache::latest();
        /** @var AppRelease $release */
        foreach ($releases as $release) {
            if (! $release->alreadyRead()) {
                return true;
            }
        }

        return $this->unreadNotifications()->count() > 0;
    }

    /**
     * Fraud detection system
     */
    public function isFrauding(): bool
    {
        // Fraud detection can be turned on or off
        if (! config('subscription.fraud_detection')) {
            return false;
        }
        // Someone with a provider (twitter, fb) login is always considered safe
        if (! empty($this->provider)) {
            return false;
        }

        $validation = $this->userValidation()->valid()->first();
        if ($validation) {
            return false;
        }

        // If the account was created recently, add some small checks
        /*if ($this->created_at->isAfter(Carbon::now()->subHour())) {
            // User's name is directly in the campaign name
            if (Str::startsWith($this->email, $this->name . '@')) {
                return true;
            } elseif ($this->campaigns()->count() === 1) {
                $campaign = $this->campaigns()->first();
                // Only the 4 starting entities
                if ($campaign->entities()->withInvisible()->count() === 4) {
                    return true;
                }
            }
        }*/
        // Recent fails are a clear indicator of someone cycling through cards
        return $this->logs()
            ->where('type_id', UserAction::failedChargeEmail)
            ->whereDate('created_at', '>=', Carbon::now()->subHour()->toDateString())
            ->count() >= 2;
    }

    /**
     * Check if the user is subscribed via PayPal
     */
    public function hasPayPal(): bool
    {
        return $this->subscribed('kanka') &&
            $this->subscription('kanka') &&
            str_contains($this->subscription('kanka')->stripe_price, 'paypal');
    }

    /**
     * Check if the user is subscribed via a manual sub
     */
    public function hasManualSubscription(): bool
    {
        return $this->subscribed('kanka') &&
            $this->subscription('kanka') &&
            Str::startsWith($this->subscription('kanka')->stripe_id, 'manual_');
    }

    /**
     * Determine in which folder to store the user's avatar. We group them by 1000 user ids to avoid
     * having one massive folder containing everything.
     */
    public function imageStoragePath(): string
    {
        return 'users/' . (int) floor($this->id / 1000);
    }
}
