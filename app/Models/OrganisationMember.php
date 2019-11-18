<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\AclTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganisationMember
 * @package App\Models
 *
 * @property integer $id
 * @property integer $character_id
 * @property integer $organisation_id
 * @property string $role
 * @property bool $is_private
 * @property Character $character
 * @property Organisation $organisation
 */
class OrganisationMember extends Model
{
    use Paginatable, VisibleTrait, Filterable, SimpleSortableTrait;

    /**
     * ACL Trait config
     * We want to get permissions on the character to know if we can see them
     */
    use AclTrait;

    public $entityType = 'character';
    public $aclFieldName = 'character_id';

    public $table = 'organisation_member';

    protected $filterableColumns = ['organisation_id'];

    protected $fillable = [
        'organisation_id',
        'character_id',
        'role',
        'is_private'
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
}
