<?php

namespace App\Datagrids\Bulks;

/**
 * Class Bulk
 *
 * This abstract class allows each sub object to define which fields are available in the
 * bulk edit interface from the main entity type's datagrid.
 */
abstract class Bulk
{
    /**
     * The fields available for bulk edit, fallsback to a set of defaults
     */
    public function fields(): array
    {
        if (isset($this->fields)) {
            return $this->fields;
        }

        return $this->defaults();
    }

    /**
     * The mapping, used for is_/has_ fields to be able to unset a value. For example a character's is_dead status
     */
    public function booleans(): array
    {
        if (isset($this->booleans)) {
            return $this->booleans;
        }

        return [];
    }

    /**
     * The list of fields that are foreign fields, to be able to properly unset(detach) them if needed
     */
    public function foreignRelations(): array
    {
        if (isset($this->foreignRelations)) {
            return $this->foreignRelations;
        }

        return [];
    }

    /**
     * Attributes that can support basic math
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
     */
    protected function defaults(): array
    {
        return [
            'name',
            'type',
            'tags',
            'private_choice',
            'entity_image',
            'entity_header',
        ];
    }
}
