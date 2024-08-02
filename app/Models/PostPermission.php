<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PostPermission
 * @package App\Models
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int $role_id
 * @property int $permission
 * @property User $user
 * @property Post $post
 */
class PostPermission extends Model
{
    public $fillable = [
        'user_id',
        'role_id',
        'post_id',
        'permission'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(CampaignRole::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     */
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

    /**
     */
    public function isUser(): bool
    {
        return !empty($this->user_id);
    }
}
