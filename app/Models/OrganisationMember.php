<?php

namespace App\Models;

use App\Models\Concerns\Filterable;
use App\Models\Concerns\Paginatable;
use App\Traits\AclTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

class OrganisationMember extends Model
{
    use Paginatable, VisibleTrait, Filterable;

    /**
     * ACL Trait config
     * We want to get permissions on the character to know if we can see them
     */
    use AclTrait;

    public $entityType = 'character';
    public $aclFieldName = 'character_id';

    public $table = 'organisation_member';

    protected $fillable = [
        'organisation_id',
        'character_id',
        'role',
        'is_private'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->filterableColumns = ['organisation_id'];
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
    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrganisationAcl($query)
    {
        $this->entityType = 'organisation';
        $this->aclFieldName = 'organisation_id';
        return $query->acl();
    }
}
