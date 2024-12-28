<?php

namespace App\Services\Entity;

use App\Http\Requests\StoreRelation;
use App\Models\Relation;
use App\Traits\CampaignAware;

class RelationService
{
    use CampaignAware;

    protected array $entities;
    protected Relation $new;
    protected int $count;

    /**
     */
    public function createRelations(StoreRelation $request): self
    {
        $this->count = 0;
        $data = $request->only([
            'owner_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id'
        ]);
        $data['campaign_id'] = $this->campaign->id;

        if ($request->has('targets')) {
            $this->entities = is_array($request->get('targets')) ? $request->get('targets') : [$request->get('targets')];
        } else {
            $this->entities = [$request->get('target_id')];
        }
        $new = null;
        foreach ($this->entities as $entity_id) {
            $data['target_id'] = $entity_id;
            $relation = new Relation();
            $relation = $relation->create($data);
            $this->count++;
            if (!isset($new)) {
                $new = $relation;
            }
            if ($request->has('two_way')) {
                $relation->createMirror();
                $this->count++;
            }
        }
        $this->new = $new;

        return $this;
    }

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getNew(): Relation
    {
        return $this->new;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
