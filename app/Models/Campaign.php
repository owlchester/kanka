<?php

namespace App\Models;

use App\Enums\CampaignFilterType;
use App\Enums\CampaignVisibility;
use App\Enums\Descendants;
use App\Enums\Permission;
use App\Enums\Visibility;
use App\Facades\CampaignCache;
use App\Facades\Mentions;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\Boosted;
use App\Models\Concerns\CampaignLimit;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasImage;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Sanitizable;
use App\Models\Relations\CampaignRelations;
use App\Models\Scopes\CampaignScopes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class Campaign
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $locale
 * @property Carbon|string $export_date
 * @property CampaignVisibility $visibility_id
 * @property bool|int $entity_visibility
 * @property bool|int $entity_personality_visibility
 * @property string $header_image
 * @property string $system
 * @property string $excerpt
 * @property string $css
 * @property string $theme
 * @property int $boost_count
 * @property int $visible_entity_count
 * @property array $ui_settings
 * @property bool|int $is_open
 * @property array|null $default_images
 * @property array|null $settings
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property int $follower
 * @property bool|int $is_hidden
 *
 * UI virtual Settings
 * @property bool|int $tooltip_family
 * @property bool|int $hide_members
 * @property bool|int $hide_history
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
    use HasImage;
    use LastSync;
    use Sanitizable;
    use SoftDeletes;

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
    ];

    protected $casts = [
        'ui_settings' => 'array',
        'default_images' => 'array',
        'settings' => 'array',
        'export_date' => 'date',
        'visibility_id' => CampaignVisibility::class,
    ];

    protected array $sanitizable = [
        'name',
    ];

    protected array $imageFields = [
        'image',
        'header_image',
    ];

    /** @var Collection|EntityType[] */
    protected Collection|array $cachedEntityTypes;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Does the campaign has a preview text that can be displayed
     */
    public function hasPreview(): bool
    {
        return ! empty($this->preview());
    }

    /**
     * Preview text for the dashboard
     */
    public function preview(): string
    {
        if (! empty(strip_tags($this->excerpt))) {
            return $this->excerpt();
        }
        if (! empty(strip_tags($this->entry))) {
            return strip_tags(mb_substr($this->parsedEntry(), 0, 1000)) . ' ...';
        }

        return '';
    }

    public function membersList($removedIds = []): array
    {
        $members = [];

        foreach ($this->members()->with('user')->get() as $m) {
            if (! in_array($m->user->id, $removedIds)) {
                $members[$m->user->id] = $m->user->name;
            }
        }

        return $members;
    }

    /**
     * Get a list of users who are admins of the campaign
     *
     * @return User[]|array|Collection
     */
    public function admins()
    {
        $users = [];
        $roles = $this->roles()
            ->with(['users', 'users.user'])
            ->where('is_admin', '1')
            ->get();
        foreach ($roles as $role) {
            foreach ($role->users as $user) {
                if (! isset($users[$user->id])) {
                    $users[$user->user->id] = $user->user;
                }
            }
        }

        return $users;
    }

    /**
     * Determine if a campaign has a module enabled or not
     */
    public function enabled(string|EntityType $module): bool
    {
        if ($module instanceof EntityType) {
            $module = $module->pluralCode();
        }
        if ($module === 'attribute_templates') {
            $module = 'entity_attributes';
        }

        return (bool) CampaignCache::campaign($this)->settings()->get($module);
    }

    public function isPublic(): bool
    {
        return $this->visibility_id == CampaignVisibility::public;
    }

    public function isPrivate(): bool
    {
        return $this->visibility_id == CampaignVisibility::private;
    }

    /**
     * Determine if the user is currently following the campaign
     */
    public function isFollowing(): bool
    {
        return $this->followers()->where('user_id', auth()->user()->id)->count() === 1;
    }

    /**
     * Determine if a campaign is discreet
     */
    public function isUnlisted(): bool
    {
        return $this->visibility_id === CampaignVisibility::unlisted;
    }

    /**
     * Determine if a campaign is open to applications
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

    public function excerpt()
    {
        return Mentions::mapAny($this, 'excerpt');
    }

    public function getExcerptForEditionAttribute()
    {
        return Mentions::parseForEdit($this, 'excerpt');
    }

    public function defaultDescendantsMode(): Descendants
    {
        return Descendants::from(Arr::get($this->ui_settings, 'descendants', 0));
    }

    public function defaultToConnection(): bool
    {
        return (bool) Arr::get($this->ui_settings, 'connections', false);
    }

    public function defaultToConnectionMode(): int
    {
        return (int) Arr::get($this->ui_settings, 'connections_mode', 0);
    }

    public function getHideMembersAttribute()
    {
        return Arr::get($this->ui_settings, 'hide_members', false);
    }

    public function getHideHistoryAttribute()
    {
        return Arr::get($this->ui_settings, 'hide_history', false);
    }

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
    public function defaultImages($withKey = false): array
    {
        if (empty($this->default_images)) {
            return [];
        }

        $imageIds = array_values($this->default_images);
        $images = Image::whereIn('id', $imageIds)->get();

        $data = [];
        foreach ($this->default_images as $type => $uuid) {
            /** @var ?Image $image */
            $image = $images->where('id', $uuid)->first();
            if (empty($image) || in_array($type, ['relations', 'bookmarks', 'menu_links'])) {
                continue;
            }
            if ($withKey) {
                $data[$type] = [
                    'type' => $type,
                    'uuid' => $uuid,
                    'path' => $image->path,
                ];
            } else {
                $data[] = [
                    'type' => $type,
                    'uuid' => $uuid,
                    'path' => $image->path,
                ];
            }
        }

        return $data;
    }

    /**
     * Determine if a campaign has plugins of the theme type
     */
    public function hasPluginTheme(): bool
    {
        return ! empty(CampaignCache::themes());
    }

    public function getDefaultVisibilityAttribute(): mixed
    {
        return Arr::get($this->settings, 'default_visibility', 'all');
    }

    public function getDefaultGalleryVisibilityAttribute(): mixed
    {
        return Arr::get($this->settings, 'gallery_visibility', 'all');
    }

    public function showPrivateEntityMentions(): bool
    {
        return Arr::get($this->settings, 'private_mention_visibility', 0);
    }

    /**
     * Determine the campaign's default visibility_id select option
     */
    public function defaultVisibility(): Visibility
    {
        $visibility = $this->getDefaultVisibilityAttribute();
        if ($visibility == 'admin' && auth()->user()->isAdmin()) {
            return Visibility::Admin;
        } elseif ($visibility == 'admin-self') {
            return Visibility::AdminSelf;
        } elseif ($visibility == 'members') {
            return Visibility::Member;
        } elseif ($visibility == 'self') {
            return Visibility::Self;
        }

        return Visibility::All;
    }

    /**
     * Determine the gallery's default visibility_id select option
     */
    public function defaultGalleryVisibility(): Visibility
    {
        $visibility = $this->getDefaultGalleryVisibilityAttribute();
        if ($visibility == 'admin' && auth()->user()->isAdmin()) {
            return Visibility::Admin;
        } elseif ($visibility == 'admin-self') {
            return Visibility::AdminSelf;
        } elseif ($visibility == 'members') {
            return Visibility::Member;
        } elseif ($visibility == 'self') {
            return Visibility::Self;
        }

        return Visibility::All;
    }

    /**
     * Checks if the campaign's public role has no read permissions
     */
    public function publicHasNoVisibility(): bool
    {
        /** @var CampaignRole $publicRole */
        $publicRole = $this->roles()->public()->first();
        $permissionCount = $publicRole->permissions()
            ->where('action', Permission::View->value)
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
        $members = CampaignCache::campaign($this)->members();

        return $members->count() > 1;
    }

    /**
     * Send a notification to the campaign's admins
     */
    public function notifyAdmins(Notification $notification): self
    {
        foreach ($this->admins() as $user) {
            $user->notify($notification);
        }

        return $this;
    }

    /**
     * Get the value of the follower variable
     */
    public function follower(): int
    {
        if (app()->hasDebugModeEnabled() && request()->has('_followers')) {
            return request()->get('_followers');
        }

        return (int) $this->follower;
    }

    public function hasModuleName(int $type, bool $plural = false): bool
    {
        $key = 'modules.' . $type . '.' . ($plural ? 'p' : 's');

        return Arr::has($this->settings, $key);
    }

    public function moduleName(int $type, bool $plural = false): ?string
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

    public function moduleIcon(int $type): ?string
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

    public function imageStoragePath(): string
    {
        return 'w/' . $this->id;
    }

    /**
     * @return Collection|EntityType[]
     */
    public function getEntityTypes(): Collection|array
    {
        if (isset($this->cachedEntityTypes)) {
            return $this->cachedEntityTypes;
        }

        $this->cachedEntityTypes = EntityType::inCampaign($this)->enabled()->get();

        return $this->cachedEntityTypes;
    }

    public function link(): string
    {
        return '<a href="' . route('dashboard', $this) . '">' . $this->name . '</a>';
    }

    public function adminRole(): array
    {
        return CampaignCache::campaign($this)->adminRole();
    }

    public function adminRoleName(): string
    {
        $role = $this->adminRole();

        return Arr::get($role, 'name', __('campaigns.roles.admin_role'));
    }

    /**
     * Helper to get a specific filter value by its Enum type
     */
    public function getFilter(CampaignFilterType $type): ?string
    {
        $filter = $this->filters->firstWhere('type', $type);

        return $filter ? $filter->entry : null;
    }
}
