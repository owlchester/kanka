<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\UserPermission;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\EntityAclTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $item_id
 * @property string $name
 * @property integer $amount
 * @property string $position
 * @property string $description
 * @property string $visibility
 * @property integer $created_by
 * @property bool $is_equipped
 * @property Item $item
 * @property Entity $entity
 */
class Inventory extends Model
{
    /**
     * Fillable fields
     */
    public $fillable = [
        'entity_id',
        'item_id',
        'name',
        'amount',
        'position',
        'description',
        'visibility',
        'created_by',
        'is_equipped',
    ];

    use VisibilityTrait, SimpleSortableTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Item');
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * List of recently used positions for the form suggestions
     * @return mixed
     */
    public static function positionList()
    {
        $campaign = CampaignLocalization::getCampaign();
        return self::acl()
            ->groupBy('position')
            ->whereNotNull('position')
            ->leftJoin('entities as e', 'e.id', 'inventories.entity_id')
            ->where('e.campaign_id', $campaign->id)
            ->orderBy('position', 'ASC')
            ->limit(20)
            ->pluck('position')
            ->all();
    }

    /**
     * Scope a query to only include elements that are visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcl($query, $action = 'read', $user = null)
    {
        // Use the User Permission Service to handle all of this easily.
        /** @var \App\Services\UserPermission $service */
        $service = UserPermission::user($user)->action($action);

        if ($service->isCampaignOwner()) {
            return $query;
        }

        return $query
            ->select('inventories.*')
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'items.id')
                    ->where('entities.type', '=', 'item');
            })
            ->where('entities.is_private', false)
            ->where(function ($subquery) use ($service) {
                return $subquery
                    ->where(function ($sub) use ($service) {
                        return $sub->whereIn('entities.id', $service->entityIds())
                            ->orWhereIn('entities.type', $service->entityTypes());
                    })
                    ->whereNotIn('entities.id', $service->deniedEntityIds());
            });
    }

    /**
     * @return string
     */
    public function itemName(): string
    {
        if (!empty($this->item)) {
            return $this->item->name;
        }
        return (string) $this->name;
    }
}
