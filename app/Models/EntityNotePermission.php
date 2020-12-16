<?php


namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EntityNotePermission
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_note_id
 * @property int $user_id
 * @property int $permission
 * @property User $user
 * @property EntityNote $note
 */
class EntityNotePermission extends Model
{
    public $fillable = [
        'user_id',
        'entity_note_id',
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
    public function note()
    {
        return $this->belongsTo(EntityNote::class);
    }

    /**
     * @return string
     */
    public function permText(): string
    {
        if ($this->permission == 1) {
            return __('crud.view');
        }
        return __('crud.update');
    }
}
