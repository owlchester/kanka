<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $conversation_id
 * @property ?int $character_id
 * @property ?Character $character
 *
 */
class ConversationParticipant extends Model
{
    use HasFactory;
    use HasUser;

    protected Character|User|null $loadedEntity;

    protected $fillable = [
        'conversation_id',
        'character_id',
        'user_id',
    ];

    /**
     * We want to use the dice_roll entity type for permissions
     */
    protected string $entityType = 'conversation_participants';

    /**
     * Who created this entry
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo('App\Models\Conversation', 'conversation_id');
    }

    public function name(): string
    {
        return $this->entity()->name ?? __('conversations.messages.author_unknown');
    }

    public function target(): int|null
    {
        return (!empty($this->character_id) ? Conversation::TARGET_CHARACTERS :
            (!empty($this->user_id) ? Conversation::TARGET_USERS : null));
    }

    public function isMember(): bool
    {
        return !empty($this->user_id);
    }

    public function id()
    {
        $entity = $this->loadEntity();
        return !empty($entity) ? $entity->id : null;
    }

    /**
     * @return Character|User|bool|\Illuminate\Database\Eloquent\Relations\HasOne|mixed
     */
    public function entity()
    {
        return $this->loadEntity();
    }

    /**
     * @return Character|User|bool|mixed
     */
    protected function loadEntity()
    {
        if (isset($this->loadedEntity)) {
            return $this->loadedEntity;
        }
        if (!empty($this->user_id)) {
            return $this->loadedEntity = $this->user;
        }
        return $this->loadedEntity = $this->character;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'conversation_id',
            'created_at',
        ];
    }
}
