<?php

namespace App\Services\Entity;

use App\Http\Requests\StoreRelation;
use App\Models\Relation;
use App\Traits\CampaignAware;

class RelationService
{
    use CampaignAware;

    /**
     */
    public function createRelations(StoreRelation $request): array
    {
        $count = 0;
        $data = $request->only([
            'owner_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id'
        ]);
        $data['campaign_id'] = $this->campaign->id;

        if ($request->has('targets')) {
            $entities = $request->get('targets');
        } else {
            $entities = [$request->get('target_id')];
        }
        foreach ($entities as $entity_id) {
            $data['target_id'] = $entity_id;
            $relation = new Relation();
            $relation = $relation->create($data);
            $count++;
            if (!isset($new)) {
                $new = $relation;
            }
            if ($request->has('two_way')) {
                $relation->createMirror();
                $count++;
            }
        }
        $results = [$new, $count];
        return $results;
    }
}
