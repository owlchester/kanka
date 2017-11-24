<?php

namespace App\Models;

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
        return $this->belongsTo('App\Character', 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisation()
    {
        return $this->belongsTo('App\Organisation', 'organisation_id');
    }
}
