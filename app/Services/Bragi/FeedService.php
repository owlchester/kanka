<?php

namespace App\Services\Bragi;

use App\Facades\Module;
use App\Models\Campaign;
use App\Models\Embedding;
use App\Models\Entity;
use Exception;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class FeedService
{
    public function feed(int $campaignId): void
    {
        $campaign = Campaign::find($campaignId);
        if (is_null($campaign)) {
            return;
        }

        $log = '';

        Module::campaign($campaign);

        try {
            $campaign->entities()
                ->with(['campaign', 'entityType', 'relationships', 'relationships.target'])
                ->has('campaign')
                ->chunkById(10, function ($entities): void {
                    foreach ($entities as $entity) {

                        $relations = $entity->relationships->map(function ($relationship) {
                            return [
                                'name'     => $relationship->target->name ?? null,
                                'relation' => $relationship->relation,
                                'attitude' => $relationship->attitude,
                            ];
                        })->toArray();

                        $entityData = [
                            'name' => $entity->name,
                            'entry' => $entity->entry,
                            'type' => $entity->entityType->name(),
                            'relations' => $relations,
                            'tags' => $entity->tags->pluck('name'),
                        ];

                        $data[] = json_encode($entityData);
                    }

                    //Get vectors
                    $response = Prism::embeddings()
                        ->using(Provider::OpenAI, 'text-embedding-3-small')
                        ->fromArray($data)
                        ->asEmbeddings();

                    // Store vectors into db
                    $embeddings = $response->embeddings;
                    $count = 0;
                    foreach ($embeddings as $id => $embedding) {
                        $entity = $entities[$count];

                        Embedding::create([
                            'parent_id'   => $entity->id,
                            'campaign_id' => $entity->campaign_id,
                            'parent_type' => Entity::class,
                            'embedding'   => $embedding->embedding, //The actual vector.
                        ]);
                        $count++;
                    }
                });
        } catch (Exception $e) {
            $log .= '<br />' . $e->getMessage();
        }
    }
}  
