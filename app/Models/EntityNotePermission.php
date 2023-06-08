<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityNotePermission
 * @package App\Models
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int $role_id
 * @property int $permission
 * @property User $user
 * @property EntityNote $note
 */
class EntityNotePermission extends Model
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
    public function note()
    {
        return $this->belongsTo(EntityNote::class, 'post_id', 'id');
    }

    /**
     * @return string
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
     * @return bool
     */
    public function isUser(): bool
    {
        return !empty($this->user_id);
    }
}
