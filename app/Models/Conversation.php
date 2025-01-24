<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Conversation
 * @package App\Models
 * @property string $name
 * @property string $image
 * @property string $type
 * @property int $target_id
 * @property bool|int $is_private
 * @property bool|int $is_closed
 *
 * @property ConversationParticipant[]|Collection $participants
 * @property ConversationMessage[]|Collection $messages
 */
class Conversation extends MiscModel
{
    use Acl;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use Sanitizable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'campaign_id',
        'target_id',
        'is_private',
        'is_closed'
    ];

    public const int TARGET_USERS = 1;
    public const int TARGET_CHARACTERS = 2;

    /**
     * Entity type
     */
    protected string $entityType = 'conversation';

    /**
     * Searchable fields
     */
    protected array $searchableColumns  = ['name'];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'target_id',
        'colour',
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * Set to false if this entity type doesn't have relations
     */
    public bool $hasRelations = false;

    /**
     * @var string[] Extra relations loaded for the API endpoint
     */
    public array $apiWith = ['messages', 'participants'];

    public function messages(): HasMany
    {
        return $this->hasMany('App\Models\ConversationMessage', 'conversation_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany('App\Models\ConversationParticipant', 'conversation_id')
            ->with('character');
    }

    /**
     * Get a list of participants
     * @return array
     */
    public function participantsList(bool $withNames = true, bool $users = false)
    {
        $participants = [];
        foreach ($this->participants as $participant) {
            if (auth()->check() && auth()->user()->can('update', $participant->character)) {
                $participants[$participant->id()] = $participant->name();
            } elseif ($users == true) {
                $participants[$participant->id()] = $participant->name();
            }
        }

        if (!$withNames) {
            return array_keys($participants);
        }

        return $participants;
    }

    /**
     * @return false|string
     */
    public function jsonParticipants()
    {
        return json_encode($this->participantsList());
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.conversation');
    }

    /**
     */
    public function forCharacters(): bool
    {
        return $this->target_id == self::TARGET_CHARACTERS;
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        return true;
    }

    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->withCount(['participants', 'messages']));
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'target_id',
            'is_closed',
        ];
    }
}
