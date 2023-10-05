<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $conversation_id
 * @property int $created_by
 * @property int|null $character_id
 * @property Character|null $character
 * @property int|null $user_id
 * @property User|null $user
 *
 */
class ConversationParticipant extends MiscModel
{
    use HasFactory;

    /**
     * @var bool|Character|User
     */
    protected $loadedEntity = false;

    /** @var string[]  */
    protected $fillable = [
        'conversation_id',
        'created_by',
        'character_id',
        'user_id',
    ];

    /**
     * We want to use the dice_roll entity type for permissions
     * @var string
     */
    protected $entityType = 'conversation_participants';

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
     * @return string
     */
    public function author()
    {
        if (!empty($this->user_id)) {
            return $this->user->name;
        } elseif (!empty($this->character_id)) {
            return link_to_route(
                'entities.show',
                $this->character->name,
                [$this->character->entity]
            );
        } else {
            return trans('conversations.messages.author_unknown');
        }
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|mixed|null|string
     */
    public function name()
    {
        return !empty($this->loadedEntity) ?
            $this->loadedEntity->name :
            trans('conversations.messages.author_unknown');
    }

    /**
     * @return int|null
     */
    public function target()
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
        if ($this->loadedEntity === false) {
            if (!empty($this->user_id)) {
                $this->loadedEntity = $this->user;
            } else {
                $this->loadedEntity = $this->character;
            }
        }

        return $this->loadedEntity;
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
