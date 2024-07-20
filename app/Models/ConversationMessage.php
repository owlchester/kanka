<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\LastSync;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class ConversationMessage
 * @package App\Models
 *
 * @property int $id
 * @property int $conversation_id
 * @property int $created_by
 * @property int $character_id
 * @property int $user_id
 * @property string $message
 *
 * @property Character|null $character
 * @property User|null $user
 * @property Conversation $conversation
 */
class ConversationMessage extends MiscModel
{
    use Blameable;
    use HasFactory;
    use LastSync;

    public $isGroupped = false;

    protected $fillable = [
        'conversation_id',
        'created_by',
        'character_id',
        'user_id',
        'message',
    ];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'conversation_id',
        'created_at',
        'created_by',
    ];

    /**
     * We want to use the dice_roll entity type for permissions
     */
    protected string $entityType = 'conversation_messages';

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo('App\Models\Conversation', 'conversation_id');
    }

    /**
     * @return int|null
     */
    public function target()
    {
        return (!empty($this->character_id) ? Conversation::TARGET_CHARACTERS :
            (!empty($this->user_id) ? Conversation::TARGET_USERS : null));
    }

    /**
     * @return string|null
     */
    public function author()
    {
        if (!empty($this->user_id)) {
            return $this->user;
        } elseif (!empty($this->character_id)) {
            return $this->character;
        }
        return null;
    }
    /**
     */
    public function authorID(): int|null
    {
        if (!empty($this->user_id)) {
            return $this->user_id;
        } elseif (!empty($this->character_id)) {
            return $this->character_id;
        }
        return null;
    }

    /**
     * @param null|int $oldestId
     * @param null|int $newestId
     */
    public function scopeDefault(Builder $query, ?int $oldestId = null, ?int $newestId = null)
    {
        $query->with(['user', 'character'])
            ->latest()
            ->take(20);

        if (!empty($oldestId)) {
            $query->where('id', '<', $oldestId);
        } elseif (!empty($newestId)) {
            $query->where('id', '>', $newestId);
        }
    }

    /**
     */
    public function isMine(): bool
    {
        return Auth::check() && $this->created_by == Auth::user()->id;
    }

    public function grouppedWith(?ConversationMessage $previous = null): self
    {
        if (empty($previous)) {
            return $this;
        }
        if ($previous->authorID() != $this->authorID()) {
            return $this;
        }
        // Same 60 seconds
        $this->isGroupped = $previous->created_at->diffInSeconds($this->created_at) < 60;

        return $this;
    }

    public function isGroup(): bool
    {
        return $this->isGroupped;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
        ];
    }
}
