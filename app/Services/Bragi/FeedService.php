<?php

namespace App\Services\Bragi;

use App\Facades\Module;
use App\Models\Campaign;
use App\Models\Embedding;
use App\Models\Entity;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Models\TimelineEra;
use Exception;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;

class FeedService
{
    public Campaign $campaign;

    public function feed(int $campaignId): void
    {
        $campaign = Campaign::find($campaignId);
        if (is_null($campaign)) {
            return;
        }

        $this->campaign = $campaign;

        $log = '';

        Module::campaign($this->campaign);

        try {
            $this->feedEntities();
            $this->feedPosts();
            $this->feedTimelineElements();
            $this->feedTimelineEras();
            $this->feedQuestElements();

        } catch (Exception $e) {
            $log .= '<br />' . $e->getMessage();
        }
    }

    protected function feedEntities(): void
    {
        $this->campaign->entities()
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
    }

    protected function feedPosts(): void
    {
        $this->campaign->posts()
            ->whereNull('layout_id')
            ->with(['entity', 'entity.campaign'])
            ->chunkById(10, function ($posts): void {
                foreach ($posts as $post) {

                    $entityData = [
                        'name' => $post->name,
                        'entry' => $post->entry,
                        'tags' => $post->tags->pluck('name'),
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
                    $post = $posts[$count];

                    Embedding::create([
                        'parent_id'   => $post->id,
                        'campaign_id' => $post->entity->campaign_id,
                        'parent_type' => Post::class,
                        'embedding'   => $embedding->embedding, //The actual vector.
                    ]);
                    $count++;
                }
            });
    }

    protected function feedQuestElements(): void
    {
        $this->campaign->questElements()
            ->with(['quest'])
            ->chunkById(10, function ($elements): void {
                foreach ($elements as $element) {

                    $entityData = [
                        'name' => $element->name,
                        'entry' => $element->description,
                        'quest' => $element->quest->name,
                        'entity' => $element->entity->name ?? '',
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
                    $element = $elements[$count];

                    Embedding::create([
                        'parent_id'   => $element->id,
                        'campaign_id' => $element->quest->campaign_id,
                        'parent_type' => QuestElement::class,
                        'embedding'   => $embedding->embedding, //The actual vector.
                    ]);
                    $count++;
                }
            });
    }

    protected function feedTimelineElements(): void
    {
        $this->campaign->timelineElements()
            ->with(['timeline', 'era'])
            ->chunkById(10, function ($elements): void {
                foreach ($elements as $element) {

                    $entityData = [
                        'name' => $element->name,
                        'entry' => $element->description,
                        'timeline' => $element->timeline->name,
                        'era' => $element->era->name,
                        'entity' => $element->entity->name ?? '',
                        'date' => $element->date,
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
                    $element = $elements[$count];

                    Embedding::create([
                        'parent_id'   => $element->id,
                        'campaign_id' => $element->timeline->campaign_id,
                        'parent_type' => TimelineElement::class,
                        'embedding'   => $embedding->embedding, //The actual vector.
                    ]);
                    $count++;
                }
            });
    }


    protected function feedTimelineEras(): void
    {
        $this->campaign->timelineEras()
            ->with(['timeline'])
            ->chunkById(10, function ($eras): void {
                foreach ($eras as $era) {

                    $entityData = [
                        'name' => $era->name,
                        'entry' => $era->entry,
                        'timeline' => $era->timeline->name,
                        'start_year' => $era->start_year,
                        'end_year' => $era->end_year
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
                    $era = $eras[$count];

                    Embedding::create([
                        'parent_id'   => $era->id,
                        'campaign_id' => $era->timeline->campaign_id,
                        'parent_type' => TimelineEra::class,
                        'embedding'   => $embedding->embedding, //The actual vector.
                    ]);
                    $count++;
                }
            });
    }

}  
