<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PostPermission
 *
 * @property int $id
 * @property int $post_id
 * @property int $role_id
 * @property int $permission
 * @property Post $post
 */
class PostPermission extends Model
{
    use HasUser;

    public $fillable = [
        'user_id',
        'role_id',
        'post_id',
        'permission',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CampaignRole, $this>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(CampaignRole::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function permText(): string
    {
        if ($this->permission == 0) {
            return __('crud.view');
        } elseif ($this->permission == 2) {
            return __('crud.permissions.actions.bulk.deny');
        }

        return __('crud.update');
    }

    public function scopeOnlyUsers($query)
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeOnlyRoles($query)
    {
        return $query->whereNotNull('role_id');
    }

    public function isUser(): bool
    {
        return ! empty($this->user_id);
    }
}
