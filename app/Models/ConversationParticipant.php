<?php

namespace App\Models;

use App\Enums\ConversationTarget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $conversation_id
 * @property ?int $participant_id
 * @property Entity|User|null $participant
 * @property string|null $participant_type
 */
class ConversationParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'participant_id',
        'participant_type',
    ];

    /**
     * Who created this entry
     *
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function participant(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo<Conversation, $this>
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo('App\Models\Conversation', 'conversation_id');
    }

    public function name(): string
    {
        $entity = $this->entity();

        return $entity->name ?? __('conversations.messages.author_unknown');
    }

    public function target(): ?int
    {
        return $this->participant_type === Entity::class ? ConversationTarget::entities->value : ($this->participant_type === User::class ? ConversationTarget::users->value : null);
    }

    public function isMember(): bool
    {
        return $this->participant instanceof User;
    }

    public function id()
    {
        $entity = $this->entity();

        return ! empty($entity) ? $entity->id : null;
    }

    public function entity(): Entity|User|null
    {
        return $this->participant instanceof Entity || $this->participant instanceof User
            ? $this->participant
            : null;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
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
