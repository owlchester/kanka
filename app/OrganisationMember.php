<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisationMember extends Model
{
    public $table = 'organisation_member';

    protected $fillable = ['organisation_id', 'character_id', 'role'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
}
