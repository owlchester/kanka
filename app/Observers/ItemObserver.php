<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\Item;
use App\Observers\Concerns\HasMany;
use App\Traits\CreatesEntityFromName;

class ItemObserver extends MiscObserver
{
    use CreatesEntityFromName;
    use HasMany;

    public function crudSaved(Item $item): void
    {
        $this->saveCreators($item);
    }

    protected function saveCreators(Item $item): self
    {
        if (! request()->has('save_creators') && ! request()->has('creators')) {
            return $this;
        }

        $creators = request()->get('creators', []);
        $this->saveMany($item, 'creators', $creators ?? [], Entity::class, 'itemCreators', 'creator_id');

        return $this;
    }
}
