<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(CampaignRole::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
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
