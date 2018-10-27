<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Paginatable;
use App\Scopes\RecentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Sofa\Eloquence\Eloquence;

/**
 * Class MiscModel
 * @package App\Models
 *
 * @property integer $campaign_id
 * @property string $name
 * @property boolean $is_private
 */
abstract class MiscModel extends Model
{
    use Paginatable;

    public static $SKIP_SAVING_OBSERVER = false;

    /**
     * Eloquence trait for easy search
     */
    //use Eloquence;

    /**
     * Entity type
     * @var
     */
    protected $entityType;

    /**
     * Entity image path
     * @var
     */
    public $entityImagePath;

    /**
     * Filterable fields
     * @var array
     */
    protected $filterableColumns = [];

    /**
     * Casting order for mysql.
     * Ex. ['age' => 'unsigned']
     * @var array
     */
    protected $orderCasting = [];

    /**
     * Explicit fields for filtering.
     * Ex. ['sex']
     * @var array
     */
    protected $explicitFilters = [];

    /**
     * Field used for tooltips
     * @var string
     */
    protected $tooltipField = 'entry';

    /**
     * Default ordering
     * @var string
     */
    protected $defaultOrderField = 'name';
    protected $defaultOrderDirection = 'asc';

    /**
     * Create a short name for the interface
     * @return mixed|string
     */
    public function shortName()
    {
        if (strlen($this->name) > 30) {
            return '<span title="' . e($this->name) . '">' . substr(e($this->name), 0, 28) . '...</span>';
        }
        return $this->name;
    }

    /**
     * Wrapper for short entry
     * @return mixed
     */
    public function tooltip($limit = 250, $stripSpecial = true)
    {
        // Always remove tags. ALWAYS.
        $pureHistory = strip_tags($this->{$this->tooltipField});


        if ($stripSpecial) {
            $pureHistory = str_replace('"', '\'', $pureHistory);
            //$pureHistory = htmlentities(htmlspecialchars($pureHistory));
        }

        $pureHistory = preg_replace("/\s/ui",' ', $pureHistory);
        $pureHistory = trim($pureHistory);

        if (!empty($pureHistory)) {
            if (strlen($pureHistory) > $limit) {
                return mb_substr($pureHistory, 0, $limit) . '...';
            }
        }
        return $pureHistory;
    }

    /**
     * Short tooltip with location name
     * @return mixed
     */
    public function tooltipWithName($limit = 250)
    {
        $text = $this->tooltip($limit);

        // e() isn't enough, remove tags too to avoid ><script injections.
        $name = e(strip_tags($this->name));

        if (empty($text)) {
            return $name;
        }
        return '<h4>' . $name . '</h4>' . $text;
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term)
    {
        $searchFields = $this->searchableColumns;
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term, $searchFields) {
            foreach ($searchFields as $field) {
                $q->orWhere($this->getTable() . '.' . $field, 'like', "%$term%");
            }
        });
    }

    /**
     * This call should be adapted in each entity model to add required "with()" statements to the query for performance
     * on the datagrids.
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with('entity');
    }

    /**
     * @param $query
     * @param $params
     * @return mixed
     */
    public function scopeFilter($query, $params)
    {
        if (!is_array($params) or empty($params) or empty($this->filterableColumns)) {
            return $query;
        }

        foreach ($params as $key => $value) {
            if (isset($value) && in_array($key, $this->filterableColumns)) {
                // It's possible to request "not" values
                $like = (isset($value[0]) && $value[0] == '!' ? 'not like' : 'like');
                $filterValue = (isset($value[0]) && $value[0] == '!') ? ltrim($value, '!') : $value;

                $segments = explode('-', $key);
                if (count($segments) > 1) {
                    $relationName = $segments[0];

                    $relation = $this->{$relationName}();
                    $foreignName = $relation->getQuery()->getQuery()->from;
                    return $query
                        ->select($this->getTable() . '.*')
                        ->with($relationName)
                        ->leftJoin($foreignName . ' as f', 'f.id', $this->getTable() . '.' . $relation->getForeignKey())
                        ->where(str_replace($relationName, 'f', str_replace('-', '.', $key)), $like, "%$filterValue%");
                } else {
                    if (in_array($key, $this->explicitFilters)) {
                        $query->where($this->getTable() . '.' . $key, $like, "$filterValue");
                    } else {
                        $query->where($this->getTable() . '.' . $key, $like, "%$filterValue%");
                    }
                }
            }
        }
        return $query;
    }

    /**
     * Scope a query to only include elements that are visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcl($query, $user = null)
    {
        if (empty($user)) {
            if (auth()->check()) {
                $user = auth()->user();
            } else {
                // No user, no roles?
            }
        }
        // Loop through the roles to build a list of ids, and check if one of our roles is an admin
        $roleIds = [];

        // Have a user? Get their roles in this campaign.
        if (!empty($user)) {
            foreach ($user->campaignRoles as $role) {
                if ($role->is_admin) {
                    return $query;
                }
                $roleIds[] = $role->id;
            }
        }

        // If the user has no roles in this campaign, we might be in Public mode
        // Load the public campaign
        if (empty($roleIds)) {
            // Get the campaign based on what's in the url
            $campaign = CampaignLocalization::getCampaign();

            // Go and get the Public role
            $publicRole = $campaign->roles()->where('is_public', true)->first();
            if ($publicRole) {
                $roleIds[] = $publicRole->id;
            }
        }

        // If one of our roles has an explicit read permission on this entity type (rather than on an individual
        // entity), we can skip the rest.
        $key = $this->entityType . '_read';
        $inRole = CampaignPermission::where(['key' => $key])
                ->whereIn('campaign_role_id', $roleIds)
                ->count() > 0;
        if ($inRole) {
            return $query;
        }


        // Specific access view to an entity for role or user
        $key = $this->entityType . '_read_';
        $entityIds = [];
        foreach (CampaignPermission::where('key', 'like', "%$key%")
                     ->where(function ($query) use ($user, $roleIds) {
                         if (!$user) {
                             return $query->whereIn('campaign_role_id', $roleIds);
                         }
                         return $query->where(['user_id' => $user->id])->orWhereIn('campaign_role_id', $roleIds);
                     })
                     ->get() as $permission) {
            // One of the permissions is a role, so we have access to all
            $entityIds[] = $permission->entityId();
        }

        return $query->whereIn($this->getTable() . '.id', $entityIds);
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return CampaignPermission::where('table_name', $this->entity->pluralType())
            ->where('key', 'like', '%_' . $this->id);
    }

    /**
     * Model's relation to a campaign
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @param $query
     * @param $field
     * @return mixed
     */
    public function scopeOrder($query, $data)
    {
        // Default
        $field = $this->defaultOrderField;
        $direction = $this->defaultOrderDirection;
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $field = $key;
                $direction = $value;
            }
        }

        // Calendar dates are handled differently since we have free fields
        if ($field == 'calendar_date') {
            return $query
                ->orderBy( $this->getTable() . '.calendar_year', $direction)
                ->orderBy( $this->getTable() . '.calendar_month', $direction)
                ->orderBy( $this->getTable() . '.calendar_day', $direction);
        }


        if (!empty($field)) {
            $segments = explode('.', $field);
            if (count($segments) > 1) {
                $relationName = $segments[0];

                $relation = $this->{$relationName}();
                $foreignName = $relation->getQuery()->getQuery()->from;
                return $query
                    ->select($this->getTable() . '.*')
                    ->with($relationName)
                    ->leftJoin($foreignName . ' as f', 'f.id', $this->getTable() . '.' . $relation->getForeignKey())
                    ->orderBy(str_replace($relationName, 'f', $field), $direction);
            } else {
                // Order by related table? Yeah that's fun.
                // While this would be possible, this would mean injecting the acl/permission system just for an order by, which seems quite overkill.
                // A better solution might present itself during a future rewrite of the acl engine.
//                if (substr($field, 0, 6) == 'count(') {
//                    $relationName = preg_replace('/count\((.*)\)/si', '$1', $field);
//                    $relation = $this->{$relationName}();
//                    $foreignName = $relation->getQuery()->getQuery()->from;
//
//                    return $query
//                        ->orderByRaw('(select count(*) from ' . $foreignName . ' where ' . $relation->getForeignKeyName() . ' = ' . $this->getTable() . '.' . $this->primaryKey . ') ' . $direction);
//                }

                // If the field has a casting
                if (!empty($this->orderCasting[$field])) {
                    return $query->orderByRaw('cast(' . $this->getTable() . '.' . $field . ' as ' . $this->orderCasting[$field] . ')', $direction);
                }
                return $query->orderBy($this->getTable() . '.' . $field, $direction);
            }
        }
    }

    /**
     * Get the image (or default image) of an entity
     * @param bool $thumb
     * @return string
     */
    public function getImageUrl($thumb = false)
    {
        if (empty($this->image)) {
            return asset('/images/defaults/' . $this->getTable() . ($thumb ? '_thumb' : null) . '.jpg');
        } else {
            return Storage::url(($thumb ? str_replace('.', '_thumb.', $this->image) : $this->image));
        }
    }

    /**
     * @return $this
     */
    public function entity()
    {
        return $this->hasOne('App\Models\Entity', 'entity_id', 'id')->where('type', $this->entityType);
    }

    /**
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param string $route
     * @return string
     */
    public function getLink($route = 'show')
    {
        return route($this->entity->pluralType() . '.' . $route, $this->id);
    }

    /**
     * @return array
     */
    public function filterableColumns()
    {
        return $this->filterableColumns;
    }

    /**
     * Detach children entities from this one. This is for the "Move" functionality, to keep a clean data set.
     */
    public function detach()
    {
        // Loop on children attributes and detach.
        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            if (strpos($attribute, '_id') !== false && $attribute != 'campaign_id') {
                $this->$attribute = null;
            }
        }
        $this->save();
    }

    /**
     * @return bool
     */
    public function hasEntry()
    {
        // If all that's in the entry is two \n, then there is no real content
        return strlen($this->entry) > 2;
    }
}
