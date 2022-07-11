<?php

namespace App\Datagrids\Bulks;

/**
 * Class Bulk
 *
 * This abstract class allows each sub object to define which fields are available in the
 * bulk edit interface from the main entity type's datagrid.
 * @package App\Datagrids\Bulks
 */
abstract class Bulk
{
    /**
     * The fields available for bulk edit, fallsback to a set of defaults
     * @return array
     */
    public function fields(): array
    {
        if (isset($this->fields)) {
            return $this->fields;
        }

        return $this->defaults();
    }

    /**
     * The mapping, used for is_ fields to be able to unset a value. For example a character's is_dead status
     * @return array
     */
    public function mappings(): array
    {
        if (isset($this->mappings)) {
            return $this->mappings;
        }

        return [];
    }

    /**
     * The list of fields that are foreign fields, to be able to properly unset them if needed
     * @return array
     */
    public function belongsTo(): array
    {
        if (isset($this->belongsTo)) {
            return $this->belongsTo;
        }

        return [];
    }

    /**
     * Attributes that can support basic math
     * @return array
     */
    public function maths(): array
    {
        if (isset($this->maths)) {
            return $this->maths;
        }

        return [];
    }

    /**
     * Default fields that are available in the bulk edit interface if no other are defined.
     * @return array
     */
    protected function defaults(): array
    {
        return [
            'name',
            'type',
            'tags',
            'private_choice'
        ];
    }
}
