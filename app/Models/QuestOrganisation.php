<?php

namespace App\Models;

use App\Traits\VisibleTrait;

class QuestOrganisation extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * ACL Trait config
     * Tell the ACL trait that we aren't looking on this model but on organisations.
     */
    public $entityType = 'organisation';
    public $aclFieldName = 'organisation_id';

    /**
     * @var string
     */
    public $table = 'quest_organisations';

    /**
     * @var array
     */
    protected $fillable = ['quest_id', 'organisation_id', 'description', 'is_private'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id');
    }
}
