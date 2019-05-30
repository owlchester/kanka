<?php

namespace App\Models\Pivots;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class QuestOrganisation
 * @package App\Models
 * @property integer $organisation_id
 * @property Organisation $organisation
 * @property string $description
 * @property string $role
 */
class QuestOrganisation extends Pivot
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
    protected $fillable = [
        'quest_id',
        'organisation_id',
        'description',
        'role',
        'is_private'
    ];

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
