<?php

namespace App\Models;

use App\Enums\ConversationTarget;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\LastSync;
use App\Observers\ConversationMessageObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
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
#[ObservedBy(ConversationMessageObserver::class)]
class ConversationMessage extends Model
{
    use Blameable;
    use HasFactory;
    use LastSync;

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

    public function isMine(): bool
    {
        return Auth::check() && $this->created_by == Auth::user()->id;
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
