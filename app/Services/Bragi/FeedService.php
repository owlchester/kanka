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
use Illuminate\Support\Facades\Log;

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
            
            Log::info('Feeding entities');
            $this->feedEntities();
            Log::info('Feeding posts');
            $this->feedPosts();
            Log::info('Feeding timeline elements');
            $this->feedTimelineElements();
            Log::info('Feeding eras');
            $this->feedTimelineEras();
            Log::info('Feeding quest elements');
            $this->feedQuestElements();

        try {


        } catch (Exception $e) {
            $log .= '<br />' . $e->getMessage();
        }
    }

    public function feedEntity(Entity $entity): void
    {
        $this->campaign = $entity->campaign;

        Module::campaign($this->campaign);

        $oldEmbed = Embedding::where('parent_type', Entity::class )->where('parent_id', $entity->id)->first();
        
        if ($oldEmbed) {
            $oldEmbed->delete();
        }

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

        //Get vector
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput(json_encode($entityData))
            ->asEmbeddings();

        // Store vector into db
        $embedding = $response->embeddings[0];

        Embedding::create([
            'parent_id'   => $entity->id,
            'campaign_id' => $entity->campaign_id,
            'parent_type' => Entity::class,
            'embedding'   => $embedding->embedding, //The actual vector.
        ]);
    }

    public function feedPost(Post $post): void
    {
        $oldEmbed = Embedding::where('parent_type', Post::class )->where('parent_id', $post->id)->first();
        
        if ($oldEmbed) {
            $oldEmbed->delete();
        }

        $postData = [
            'name' => $post->name,
            'entry' => $post->entry,
            'tags' => $post->tags->pluck('name'),
        ];

        //Get vector
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput(json_encode($postData))
            ->asEmbeddings();

        // Store vectors into db
        $embedding = $response->embeddings[0];
        Embedding::create([
            'parent_id'   => $post->id,
            'campaign_id' => $post->entity->campaign_id,
            'parent_type' => Post::class,
            'embedding'   => $embedding->embedding, //The actual vector.
        ]);
    }

    public function feedQuestElement(QuestElement $element): void
    {
        $oldEmbed = Embedding::where('parent_type', QuestElement::class )->where('parent_id', $element->id)->first();
        
        if ($oldEmbed) {
            $oldEmbed->delete();
        }

        $elementData = [
            'name' => $element->name,
            'entry' => $element->description,
            'quest' => $element->quest->name,
            'entity' => $element->entity->name ?? '',
        ];

        //Get vector
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput(json_encode($elementData))
            ->asEmbeddings();

        // Store vector into db
        $embedding = $response->embeddings[0];

        Embedding::create([
            'parent_id'   => $element->id,
            'campaign_id' => $element->quest->campaign_id,
            'parent_type' => QuestElement::class,
            'embedding'   => $embedding->embedding, //The actual vector.
        ]);       
    }

    public function feedTimelineElement(TimelineElement $element): void
    {
        $oldEmbed = Embedding::where('parent_type', TimelineElement::class )->where('parent_id', $element->id)->first();
        
        if ($oldEmbed) {
            $oldEmbed->delete();
        }

        $elementData = [
            'name' => $element->name,
            'entry' => $element->description,
            'timeline' => $element->timeline->name,
            'era' => $element->era->name,
            'entity' => $element->entity->name ?? '',
            'date' => $element->date,
        ];

        //Get vector
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput(json_encode($elementData))
            ->asEmbeddings();

        // Store vector into db
        $embedding = $response->embeddings[0];

        Embedding::create([
            'parent_id'   => $element->id,
            'campaign_id' => $element->timeline->campaign_id,
            'parent_type' => TimelineElement::class,
            'embedding'   => $embedding->embedding, //The actual vector.
        ]);
    }

    public function feedTimelineEra(TimelineEra $era): void
    {
        $oldEmbed = Embedding::where('parent_type', TimelineEra::class )->where('parent_id', $era->id)->first();
        
        if ($oldEmbed) {
            $oldEmbed->delete();
        }

        $eraData = [
            'name' => $era->name,
            'entry' => $era->entry,
            'timeline' => $era->timeline->name,
            'start_year' => $era->start_year,
            'end_year' => $era->end_year
        ];

        //Get vector
        $response = Prism::embeddings()
            ->using(Provider::OpenAI, 'text-embedding-3-small')
            ->fromInput(json_encode($eraData))
            ->asEmbeddings();

        // Store vector into db
        $embedding = $response->embeddings[0];
        Embedding::create([
            'parent_id'   => $era->id,
            'campaign_id' => $era->timeline->campaign_id,
            'parent_type' => TimelineEra::class,
            'embedding'   => $embedding->embedding, //The actual vector.
        ]);
    }

    protected function feedEntities(): void
    {
        $this->campaign->entities()
            ->with(['campaign', 'entityType', 'relationships', 'relationships.target'])
            ->has('campaign')
            ->chunkById(1, function ($entities): void {
                $count = 0;
                foreach ($entities as $entity) {
                    $count = $count + 1;
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
                Log::info('Feeding ' . $count . ' entities');
                Log::info('Feeding ', $data);

                

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
            ->chunkById(3, function ($posts): void {
                foreach ($posts as $post) {

                    $entityData = [
                        'name' => $post->name,
                        'entity' => $post->entity->name,
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
            ->chunkById(3, function ($elements): void {
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
            ->chunkById(3, function ($elements): void {
                foreach ($elements as $element) {

                    $elementData = [
                        'name' => $element->name,
                        'entry' => $element->description,
                        'timeline' => $element->timeline->name,
                        'era' => $element->era->name,
                        'entity' => $element->entity->name ?? '',
                        'date' => $element->date,
                    ];

                    $data[] = json_encode($elementData);
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
            ->chunkById(3, function ($eras): void {
                foreach ($eras as $era) {

                    $eraData = [
                        'name' => $era->name,
                        'entry' => $era->entry,
                        'timeline' => $era->timeline->name,
                        'start_year' => $era->start_year,
                        'end_year' => $era->end_year
                    ];

                    $data[] = json_encode($eraData);
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
