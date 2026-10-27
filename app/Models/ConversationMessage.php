<?php

namespace App\Models;

use App\Enums\ConversationTarget;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\LastSync;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

/**
 * Class ConversationMessage
 *
 * @property int $id
 * @property int $conversation_id
 * @property int $participant_id
 * @property string $message
 * @property Entity|User|null $participant
 * @property string|null $participant_type
 * @property Conversation $conversation
 * @property Carbon $created_at
 */
class ConversationMessage extends Model
{
    use Blameable;
    use HasFactory;
    use LastSync;

    public bool $isGroupped = false;

    protected $fillable = [
        'conversation_id',
        'created_by',
        'participant_id',
        'participant_type',
        'message',
    ];

    /**
     * Fields that can be filtered on
     *
     * @var array
     */
    protected $filterableColumns = [
        'conversation_id',
        'created_at',
        'created_by',
    ];

    /** @return MorphTo<Model, $this> */
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

    /**
     * @return int|null
     */
    public function target()
    {
        return $this->participant_type === Entity::class ? ConversationTarget::entities->value : ($this->participant_type === User::class ? ConversationTarget::users->value : null);
    }

    /**
     * @return string|null
     */
    public function author()
    {
        return $this->participant;
    }

    public function authorID(): ?int
    {
        return $this->participant_id;
    }

    public function scopeDefault(Builder $query, ?int $oldestId = null, ?int $newestId = null)
    {
        $query->with('participant')
            ->latest()
            ->take(20);

        if (! empty($oldestId)) {
            $query->where('id', '<', $oldestId);
        } elseif (! empty($newestId)) {
            $query->where('id', '>', $newestId);
        }
    }

    public function isMine(): bool
    {
        return Auth::check() && $this->created_by == Auth::user()->id;
    }

    public function grouppedWith(?ConversationMessage $previous = null): self
    {
        if (empty($previous)) {
            return $this;
        }
        if ($previous->participant_type !== $this->participant_type || $previous->authorID() != $this->authorID()) {
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
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
        ];
    }
}
