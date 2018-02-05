<?php

namespace App\Models;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Attribute extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'name',
        'value',
        'is_private',
    ];

    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
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
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
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
}
