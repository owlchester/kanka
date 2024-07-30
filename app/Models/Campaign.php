<?php

namespace App\Models;

use App\Facades\CampaignCache;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\Concerns\Boosted;
use App\Models\Concerns\CampaignLimit;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Sanitizable;
use App\Models\Relations\CampaignRelations;
use App\Models\Scopes\CampaignScopes;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Campaign
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $locale
 * @property string $image
 * @property Carbon|string $export_date
 * @property int $visibility_id
 * @property bool $entity_visibility
 * @property bool $entity_personality_visibility
 * @property string $header_image
 * @property string $system
 * @property string $excerpt
 * @property string $css
 * @property string $theme
 * @property int $boost_count
 * @property int $visible_entity_count
 * @property array $ui_settings
 * @property bool|int $is_open
 * @property bool|int $is_featured
 * @property bool|int $is_discreet
 * @property Carbon $featured_until
 * @property string $featured_reason
 * @property array|null $default_images
 * @property array|null $settings
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property int $follower
 * @property bool $is_hidden
 *
 * UI virtual Settings
 * @property bool $tooltip_family
 * @property bool $tooltip_image
 * @property bool $hide_members
 * @property bool $hide_history
 *
 */
class Campaign extends Model
{
    use Blameable;
    use Boosted;
    use CampaignLimit;
    use CampaignRelations;
    use CampaignScopes;
    use HasEntry;
    use HasFactory;
    use LastSync;
    use Sanitizable;
    use SoftDeletes;

    /**
     * Visibility of a campaign
     */
    public const VISIBILITY_PRIVATE = 1;
    public const VISIBILITY_REVIEW = 2;
    public const VISIBILITY_PUBLIC = 3;

    public const LAYER_COUNT_MIN = 1;
    public const LAYER_COUNT_MAX = 10;

    protected $fillable = [
        'name',
        'slug',
        'locale',
        'entry',
        'excerpt',
        'image',
        'export_date',
        'visibility_id',
        'entity_visibility',
        'entity_personality_visibility',
        'header_image',
        'system',
        'theme_id',
        'css',
        'ui_settings',
        'settings',
        'is_open',
        'is_discreet',
    ];

    protected $casts = [
        'ui_settings' => 'array',
        'default_images' => 'array',
        'settings' => 'array',
        'featured_until' => 'date',
        'export_date' => 'date',
    ];

    protected array $sanitizable = [
        'name',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Does the campaign has a preview text that can be displayed
     */
    public function hasPreview(): bool
    {
        return !empty($this->preview());
    }

    /**
     * Preview text for the dashboard
     */
    public function preview(): string
    {
        if (!empty(strip_tags($this->excerpt))) {
            return $this->excerpt();
        }
        if (!empty(strip_tags($this->entry))) {
            return strip_tags(mb_substr($this->parsedEntry(), 0, 1000)) . ' ...';
        }
        return '';
    }

    /**
     */
    public function membersList($removedIds = []): array
    {
        $members = [];

        foreach ($this->members()->with('user')->get() as $m) {
            if (!in_array($m->user->id, $removedIds)) {
                $members[$m->user->id] = $m->user->name;
            }
        }

        return $members;
    }

    /**
     * Get a list of users who are admins of the campaign
     * @return User[]|array|Collection
     */
    public function admins()
    {
        $users = [];
        // @phpstan-ignore-next-line
        $roles = $this->roles()
            ->with(['users', 'users.user'])
            ->where('is_admin', '1')
            ->get();
        foreach ($roles as $role) {
            foreach ($role->users as $user) {
                if (!isset($users[$user->id])) {
                    $users[$user->user->id] = $user->user;
                }
            }
        }
        return $users;
    }

    /**
     * Count the number of admins in a campaign. Used by the CampaignPolicy
     */
    public function adminCount(): int
    {
        return $this->roles()
            ->admin()
            ->first()
            ->users
            ->count();
    }

    /**
     * Determine if the user is in the campaign
     */
    public function userIsMember(User $user = null): bool
    {
        if (empty($user)) {
            $user = auth()->user();
        }

        return CampaignCache::members()->where('id', $user->id)->count() == 1;
    }

    /**
     * Determine if a campaign has a module enabled or not
     *
     */
    public function enabled(string $module): bool
    {
        if ($module === 'attribute_templates') {
            $module = 'entity_attributes';
        }

        return (bool) CampaignCache::settings()->get($module);
    }

    /**
     * Get the is public attribute for forms
     */
    public function getIsPublicAttribute()
    {
        return $this->visibility_id == self::VISIBILITY_PUBLIC;
    }

    /**
     * Determine if the user is currently following the campaign
     */
    public function isFollowing(): bool
    {
        return $this->followers()->where('user_id', auth()->user()->id)->count() === 1;
    }

    /**
     * Determine if a campaign is public
     */
    public function isPublic(): bool
    {
        return $this->visibility_id == self::VISIBILITY_PUBLIC;
    }

    /**
     * Determine if a campaign is discreet
     */
    public function isDiscreet(): bool
    {
        return $this->is_discreet;
    }

    /**
     *
     * Determine if a campaign is open to submissions
     */
    public function isOpen(): bool
    {
        return $this->is_open;
    }

    /**
     * Determine if a campaign is hidden
     */
    public function isHidden(): bool
    {
        return $this->is_hidden;
    }

    /**
     */
    public function excerpt()
    {
        return Mentions::mapAny($this, 'excerpt');
    }

    /**
     */
    public function getExcerptForEditionAttribute()
    {
        return Mentions::parseForEdit($this, 'excerpt');
    }

    /**
     * Determine if the campaign has images in tooltips.
     */
    public function getTooltipImageAttribute()
    {
        return Arr::get($this->ui_settings, 'tooltip_image', false);
    }

    /**
     */
    public function defaultToNested(): bool
    {
        return (bool) Arr::get($this->ui_settings, 'nested', false);
    }

    /**
     */
    public function defaultToConnection(): bool
    {
        return (bool) Arr::get($this->ui_settings, 'connections', false);
    }

    /**
     */
    public function defaultToConnectionMode(): int
    {
        return (int) Arr::get($this->ui_settings, 'connections_mode', 0);
    }

    /**
     */
    public function getHideMembersAttribute()
    {
        return Arr::get($this->ui_settings, 'hide_members', false);
    }


    /**
     */
    public function getHideHistoryAttribute()
    {
        return Arr::get($this->ui_settings, 'hide_history', false);
    }

    /**
     * Number of layers a map of a campaign can have
     */
    public function maxMapLayers(): int
    {
        if ($this->boosted()) {
            return self::LAYER_COUNT_MAX;
        }
        return self::LAYER_COUNT_MIN;
    }

    /**
     */
    public function maxEntityFiles(): int
    {
        if ($this->premium()) {
            return config('limits.campaigns.files.premium');
        } elseif ($this->superboosted()) {
            return config('limits.campaigns.files.superboosted');
        }
        if ($this->boosted()) {
            return config('limits.campaigns.files.boosted');
        }
        return config('limits.campaigns.files.standard');
    }

    /**
     */
    public function existingDefaultImages(): array
    {
        if (empty($this->default_images)) {
            return [];
        }

        return array_keys($this->default_images);
    }

    /**
     * Prepare the default entity images
     */
    public function defaultImages(): array
    {
        if (empty($this->default_images)) {
            return [];
        }

        $imageIds = array_values($this->default_images);
        $images = Image::whereIn('id', $imageIds)->get();

        $data = [];
        foreach ($this->default_images as $type => $uuid) {
            /** @var Image|null $image */
            $image = $images->where('id', $uuid)->first();
            if (empty($image) || in_array($type, ['relations', 'bookmarks', 'menu_links'])) {
                continue;
            }

            $data[] = [
                'type' => $type,
                'uuid' => $uuid,
                'path' => $image->path,
            ];
        }

        return $data;
    }

    /**
     * Determine if a campaign has plugins of the theme type
     */
    public function hasPluginTheme(): bool
    {
        return !empty(CampaignCache::themes());
    }


    /**
     * @return array|\ArrayAccess|mixed
     */
    public function getDefaultVisibilityAttribute()
    {
        return Arr::get($this->settings, 'default_visibility', 'all');
    }

    /**
     * Determine the campaign's default visibility_id select option
     */
    public function defaultVisibilityID(): int
    {
        $visibility = $this->default_visibility;

        if ($visibility == 'admin' && auth()->user()->isAdmin()) {
            return \App\Enums\Visibility::Admin->value;
        } elseif ($visibility == 'admin-self') {
            return (int) \App\Enums\Visibility::AdminSelf->value;
        } elseif ($visibility == 'members') {
            return (int) \App\Enums\Visibility::Member->value;
        } elseif ($visibility == 'self') {
            return (int) \App\Enums\Visibility::Self->value;
        }

        return (int) \App\Enums\Visibility::All->value;
    }

    /**
     * Checks if the campaign's public role has no read permissions
     */
    public function publicHasNoVisibility(): bool
    {
        /** @var CampaignRole $publicRole */
        $publicRole = $this->roles()->public()->first();
        $permissionCount = $publicRole->permissions()
            ->where('action', CampaignPermission::ACTION_READ)
            ->where('access', 1)
            ->count();
        return $permissionCount == 0;
    }

    /**
     * Determine if a campaign has editing warnings (when multiple people are trying to edit
     * the same entity). This is enabled if the campaign has several members.
     */
    public function hasEditingWarning(): bool
    {
        $members = CampaignCache::members();
        return $members !== null && $members->count() > 1;
    }

    /**
     * Send a notification to the campaign's admins
     * @return $this
     */
    public function notifyAdmins(Notification $notification): self
    {
        foreach ($this->admins() as $user) {
            $user->notify($notification);
        }
        return $this;
    }

    /**
     * Get the campaign's thumbnail url
     * @return string
     */
    public function thumbnail(int $width = 400, int $height = null, string $field = 'image')
    {
        if (empty($this->$field)) {
            return '';
        }
        return Img::resetCrop()
            ->crop($width, (!empty($height) ? $height : $width))
            ->url($this->$field);
    }

    /**
     * Determine if a campaign can be exported, or if it already hit the daily maximum
     */
    public function exportable(): bool
    {
        if (!app()->isProduction()) {
            return true; //$this->queuedCampaignExports->count() === 0;
        }

        return empty($this->export_date) || !$this->export_date->isToday() && $this->queuedCampaignExports->count() === 0;
    }

    /**
     * Get the value of the follower variable
     */
    public function follower(): int
    {
        return (int) $this->follower;
    }

    public function hasModuleName(int $type, bool $plural = false): bool
    {
        $key = 'modules.' . $type . '.' . ($plural ? 'p' : 's');
        return Arr::has($this->settings, $key);
    }

    public function moduleName(int $type, bool $plural = false): string|null
    {
        $key = 'modules.' . $type . '.' . ($plural ? 'p' : 's');
        $val = Arr::get($this->settings, $key);
        return $val;
    }

    public function hasModuleIcon(int $type): bool
    {
        $key = 'modules.' . $type . '.i';
        return Arr::has($this->settings, $key);
    }

    public function moduleIcon(int $type): string|null
    {
        $key = 'modules.' . $type . '.i';
        $val = Arr::get($this->settings, $key);
        return $val;
    }

    public function hasVanity(): bool
    {
        return $this->slug != $this->id;
    }

    public function getSystems(): string
    {
        $systems = '';
        foreach ($this->systems as $system) {
            if ($systems) {
                $systems .= ', ';
            }
            $systems .= $system->name;
        }
        return $systems;
    }
}
