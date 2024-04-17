<?php

namespace App\Models;

use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Privatable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrganisationMember
 * @package App\Models
 *
 * @property int $id
 * @property int $character_id
 * @property int $organisation_id
 * @property int $parent_id
 * @property string $role
 * @property bool $is_private
 * @property int $pin_id
 * @property int $status_id
 * @property Character $character
 * @property Organisation $organisation
 * @property OrganisationMember $parent
 *
 */
class OrganisationMember extends Model
{
    use HasFilters;
    use Paginatable;
    use Privatable;
    use SortableTrait;

    public const PIN_CHARACTER = 1;
    public const PIN_ORGANISATION = 2;
    public const PIN_BOTH = 3;

    public const STATUS_ACTIVE = 0;
    public const STATUS_INACTIVE = 1;
    public const STATUS_UNKNOWN = 2;

    public $entityType = 'character';
    public $aclFieldName = 'character_id';

    public $table = 'organisation_member';

    protected $filterableColumns = ['organisation_id'];

    protected $fillable = [
        'organisation_id',
        'character_id',
        'role',
        'is_private',
        'pin_id',
        'status_id',
        'parent_id',
    ];

    protected array $sortable = [
        'organisation.name',
        'character.name',
        'parent_id',
        'role',
        //'character.location.name',
    ];

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
    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\OrganisationMember', 'parent_id');
    }

    public function tags()
    {
        return $this->organisation->entity->tags;
    }

    /**
     */
    public function pinned(): bool
    {
        return !empty($this->pin_id);
    }

    /**
     */
    public function pinnedToCharacter(): bool
    {
        return $this->pin_id == self::PIN_CHARACTER;
    }

    /**
     */
    public function pinnedToOrganisation(): bool
    {
        return $this->pin_id == self::PIN_ORGANISATION;
    }

    /**
     */
    public function pinnedToBoth(): bool
    {
        return $this->pin_id == self::PIN_BOTH;
    }

    /**
     */
    public function inactive(): bool
    {
        return $this->status_id === self::STATUS_INACTIVE;
    }

    /**
     */
    public function unknown(): bool
    {
        return $this->status_id === self::STATUS_UNKNOWN;
    }

    /**
     * @return Builder
     */
    public function scopePinned(Builder $query, int $pin)
    {
        return $query->where('pin_id', $pin);
    }

    /**
     * Datagrid2: delete name
     */
    public function deleteName(): string
    {
        return $this->character->name;
    }

    /**
     * Foreign selected
     */
    public function getNameAttribute(): string
    {
        return $this->character->name;
    }

    /**
     * Datagrid2: url
     */
    public function url(string $where): string
    {
        return 'characters.character_organisations.' . $where;
    }

    /**
     * Datagrid2: route options
     */
    public function routeParams(array $options = []): array
    {
        return $options + ['character' => $this->character, 'character_organisation' => $this];
    }

    /**
     */
    public function scopeRows(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query
            ->select('organisation_member.*')
            ->sort(request()->only(['o', 'k']), ['c.name' => 'asc'])
            ->with(['character', 'character.entity', 'organisation', 'organisation.entity', 'organisation.location', 'organisation.location.entity'])
            ->has('organisation')
            ->has('organisation.entity')
            ->leftJoin('organisations as c', 'c.id', 'organisation_member.organisation_id');
    }
}
