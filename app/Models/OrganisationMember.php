<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use App\Traits\AclTrait;
use Illuminate\Database\Eloquent\Model;

class OrganisationMember extends Model
{
    /**
     * ACL Trait config
     */
    use AclTrait;
    use Paginatable;
    
    public $entityType = 'character';
    public $aclFieldName = 'character_id';

    public $table = 'organisation_member';

    protected $fillable = ['organisation_id', 'character_id', 'role'];

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
