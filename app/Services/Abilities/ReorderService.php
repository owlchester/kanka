<?php

namespace App\Services\Abilities;

use App\Http\Requests\ReorderAbility;
use App\Models\EntityAbility;
use App\Traits\EntityAware;

class ReorderService
{
    use EntityAware;

    /**
     */
    public function reorder(ReorderAbility $request): bool
    {
        $ids = $request->get('ability');

        if (empty($ids)) {
            return false;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var ?EntityAbility $ability */
            $ability = EntityAbility::find($id);
            if ($ability === null || $ability->entity_id !== $this->entity->id) {
                continue;
            }

            $ability->position = $position;
            $ability->saveQuietly();
            $position++;
        }
        return true;
    }
}
