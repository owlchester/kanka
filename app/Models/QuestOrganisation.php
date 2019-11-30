<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibleTrait;

/**
 * Class QuestOrganisation
 * @package App\Models
 * @property integer $organisation_id
 * @property Organisation $organisation
 * @property string $description
 * @property string $role
 * @property string $colour
 * @property integer $impact
 */
class QuestOrganisation extends QuestElement
{
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
    protected $fillable = [
        'quest_id',
        'organisation_id',
        'description',
        'role',
        'colour',
        'impact',
        'is_private'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id');
    }
}
