<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignPermission
 * @package App\Models
 *
 * @property int $entity_id
 * @property int $campaign_role_id
 * @property int $campaign_id
 * @property int $entity_type_id
 * @property int $action
 * @property string $key
 * @property string $table_name
 * @property bool|int $access
 * @property int $misc_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Campaign $campaign
 * @property CampaignRole $campaignRole
 * @property Entity $entity
 *
 * @method static self|Builder roleIds(array $ids)
 */
class CampaignPermission extends Model
{
    use HasUser;

    public const ACTION_READ = 1;
    public const ACTION_EDIT = 2;
    public const ACTION_ADD = 3;
    public const ACTION_DELETE = 4;
    public const ACTION_POSTS = 5;
    public const ACTION_PERMS = 6;

    public const ACTION_MANAGE = 10;
    public const ACTION_DASHBOARD = 11;
    public const ACTION_MEMBERS = 12;
    public const ACTION_GALLERY = 13;
    public const ACTION_CAMPAIGN = 14;

    public const ACTION_GALLERY_BROWSE = 15;
    public const ACTION_GALLERY_UPLOAD = 16;

    public const ACTION_TEMPLATES = 17;
    public const ACTION_POST_TEMPLATES = 18;
    public const ACTION_BOOKMARKS = 19;

    protected $fillable = [
        'campaign_role_id',
        'campaign_id',
        'user_id',
        'action',
        'entity_id',
        'entity_type_id',
        'misc_id',
        'access',
    ];

    /**
     * Optional campaign role
     */
    public function campaignRole(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignRole', 'campaign_role_id', 'id');
    }

    /**
     * Optional entity
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     */
    public function scopeRoleIDs(Builder $query, array $roleIds): Builder
    {
        return $query->whereIn('campaign_role_id', $roleIds);
    }

    /**
     */
    public function scopeAction(Builder $query, int $action): Builder
    {
        return $query->whereIn('action', $action);
    }

    /**
     * Copy an entity inventory to another target
     */
    public function copyTo(Entity $target, int $from, int $to)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        $new->misc_id = $target->entity_id;
        return $new->save();
    }

    /**
     * Determine if the permission's action is the wanted one
     */
    public function isAction(int $action): bool
    {
        return $this->action === $action;
    }

    /**
     * Get the "key" of the permission, used for caching and lookup in the permission engines
     */
    public function key(): string
    {
        // Campaign actions have a different cache key
        if ($this->action >= 10) {
            return 'campaign_' . $this->action;
        }

        // If there is no entity attached, just go entity type + action
        if (!$this->entity_id) {
            return $this->entity_type_id . '_' . $this->action;
        }
        // Jul 2022: Found out a bug that if the entity_type_id isn't set even on user perms, denying misc_id 2 would
        // deny all (families, orgs, tags) with ID 2. Due to Kanka's size, very low collusion size, but still
        /*if ($this->entity_type_id) {
            return '_' . $this->action . '_' . $this->entity_type_id . '_' . $this->misc_id;
        }*/
        return '_' . $this->action . '_' . $this->entity_id;
    }

    public function isGallery(): bool
    {
        $galleryPermissions = [
            self::ACTION_GALLERY,
            self::ACTION_GALLERY_BROWSE,
            self::ACTION_GALLERY_UPLOAD,
        ];
        return in_array($this->action, $galleryPermissions);
    }

    public function isTemplate(): bool
    {
        $templatePermissions = [
            self::ACTION_TEMPLATES,
            self::ACTION_POST_TEMPLATES,
        ];
        return in_array($this->action, $templatePermissions);
    }

    public function isBookmark(): bool
    {
        $templatePermissions = [
            self::ACTION_BOOKMARKS,
        ];
        return in_array($this->action, $templatePermissions);
    }
}
