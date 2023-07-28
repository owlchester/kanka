<?php

namespace App\Observers\Concerns;

use App\Models\Entity;
use App\Models\MiscModel;

trait Copiable
{
    protected Entity $sourceEntity;
    protected Entity $newEntity;

    public function copy(Entity $entity)
    {
        $this->newEntity = $entity;
        $this->copyPosts()
            ->copyLinks()
            ->copyAbilities()
            ->copyInventory()
            ->copyPermissions();
    }

    protected function sourceEntity(): Entity
    {
        if (!isset($this->sourceEntity)) {
            $sourceId = request()->post('copy_source_id');
            $this->sourceEntity = Entity::findOrFail($sourceId);
        }
        return $this->sourceEntity;
    }

    protected function copyPosts(): self
    {
        if (request()->has('copy_source_notes') && request()->filled('copy_source_notes')) {
            $source = $this->sourceEntity();
            foreach ($source->posts as $post) {
                $post->copyTo($this->newEntity);
            }
        }
        return $this;
    }

    protected function copyLinks(): self
    {
        if (!request()->has('copy_source_links') || !request()->filled('copy_source_links')) {
            return $this;
        }
        $source = $this->sourceEntity();
        foreach ($source->assets()->link()->get() as $link) {
            $link->copyTo($this->newEntity);
        }
        return $this;
    }

    protected function copyAbilities(): self
    {
        if (request()->has('copy_source_abilities') && request()->filled('copy_source_abilities')) {
            $source = $this->sourceEntity();
            foreach ($source->abilities as $ability) {
                $ability->copyTo($this->newEntity);
            }
        }
        return $this;
    }

    protected function copyPermissions(): self
    {
        if (request()->has('copy_source_permissions') && request()->filled('copy_source_permissions')) {
            $source = $this->sourceEntity();
            foreach ($source->permissions as $perm) {
                $perm->copyTo($this->newEntity, $source->entity_id, $this->newEntity->entity_id);
            }
        }
        return $this;
    }

    protected function copyInventory(): self
    {
        if (request()->has('copy_source_inventory') && request()->filled('copy_source_inventory')) {
            $source = $this->sourceEntity();
            foreach ($source->inventories as $inventory) {
                $inventory->copyTo($this->newEntity);
            }
        }
        return $this;
    }
}
