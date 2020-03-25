<?php


namespace App\Datagrids\Bulks;

/**
 * Class Bulk
 * @package App\Datagrids\Bulks
 */
abstract class Bulk
{
    /**
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
