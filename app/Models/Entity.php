<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class Entity
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $campaign_id
 * @property string $name
 * @property string $enum
 * @property boolean $is_private
 */
class Entity extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'entity_id',
        'name',
        'type',
        'is_private',
    ];

    /**
     * Traits
     */
    use CampaignTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * Get the child location
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function child()
    {
        return $this->{$this->type}();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany('App\Models\Attribute', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attribute_template()
    {
        return $this->hasOne('App\Models\AttributeTemplate', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function character()
    {
        return $this->hasOne('App\Models\Character', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event()
    {
        return $this->hasOne('App\Models\Event', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function family()
    {
        return $this->hasOne('App\Models\Family', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function item()
    {
        return $this->hasOne('App\Models\Item', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function journal()
    {
        return $this->hasOne('App\Models\Journal', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function note()
    {
        return $this->hasOne('App\Models\Note', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organisation()
    {
        return $this->hasOne('App\Models\Organisation', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quest()
    {
        return $this->hasOne('App\Models\Quest', 'id', 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function calendar()
    {
        return $this->hasOne('App\Models\Calendar', 'id', 'entity_id');
    }

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
     * @return null
     */
    public function tooltip()
    {
        return $this->child ? $this->child->tooltip() : null;
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            foreach ($this->searchableColumns as $col) {
                $q->orWhere($col, 'like', '%$term%');
            }
        });
    }

    /**
     * @return string
     */
    public function pluralType()
    {
        if ($this->type == 'family') {
            return 'families';
        }
        return $this->type . 's';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany('App\Models\Relation', 'owner_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function targetRelationships()
    {
        return $this->hasMany('App\Models\Relation', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Models\EntityNote', 'entity_id', 'id');
    }
}
