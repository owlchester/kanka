<?php

namespace App\Services\Search;

use App\Models\Entity;
use App\Models\Attribute;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Models\Post;
use App\Traits\CampaignAware;
use Illuminate\Support\Str;
use Meilisearch\Client;

class EntitySearchService
{
    use CampaignAware;

    protected array $ids = [];
    protected array $attributeIds = [];
    protected array $timelineElementIds = [];
    protected array $postIds = [];
    protected array $questElementIds = [];

    /**
     * Send search request
     */
    public function search(string $term = null): array
    {
        //Get results from Meilisearch
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->getKeys();
        $results = $client->index('entities')
            ->search($term, [
                'filter' => 'campaign_id = ' . $this->campaign->id,
                'attributesToRetrieve' => [
                    'id', 'entity_id', 'type'
                ],
                'attributesToSearchOn' => [
                    'name', 'entry', 'entity_name', 'value'
                ],
                'limit' => 20
            ])->getHits();

        return $this->process($results)->fetch();
    }

    /**
     * Process results to fetch entities from db
     * @param array $results Search term
     */
    protected function process(array $results = []): self
    {
        foreach ($results as $result) {
            if ($result['type'] == 'quest_element') {
                $id = Str::afterLast($result['id'], '_');
                $this->questElementIds[$result['entity_id']] = $id;
            //dd($result);
            } elseif ($result['type'] == 'timeline_element') {
                $id = Str::afterLast($result['id'], '_');
                $this->timelineElementIds[$result['entity_id']] = $id;
            //dd($result);
            } elseif ($result['type'] == 'post') {
                $id = Str::afterLast($result['id'], '_');
                $this->postIds[$result['entity_id']] = $id;
            //dd($result);
            } elseif ($result['type'] == 'attribute') {
                $id = Str::afterLast($result['id'], '_');
                $this->attributeIds[$result['entity_id']] = $id;
            //dd($result);
            } else {
                $this->ids[$result['entity_id']] = $result['entity_id'];
            }
        }

        //If the search also threw the entity as a possible result don't bother loading the other models
        $this->attributeIds = array_diff_key($this->attributeIds, $this->ids);
        $this->timelineElementIds = array_diff_key($this->timelineElementIds, $this->ids);
        $this->questElementIds = array_diff_key($this->questElementIds, $this->ids);
        $this->postIds = array_diff_key($this->postIds, $this->ids);

        return $this;
    }

    /**
     * Fetch entities from DB
     */
    protected function fetch(): array
    {
        $posts = Post::whereIn('id', $this->postIds)->get();
        $attributes = Attribute::with('entity')->has('entity')->whereIn('id', $this->attributeIds)->get();
        $questElements = QuestElement::with(['quest', 'quest.entity'])->has('quest')->whereIn('id', $this->questElementIds)->get();
        $timelineElements = TimelineElement::with(['timeline', 'timeline.entity'])->has('timeline')->whereIn('id', $this->timelineElementIds)->get();

        //Get entities from db
        $entities = Entity::whereIn('id', $this->ids)->get();

        //Process entities for output
        $output = [];
        foreach ($entities as $entity) {
            $output[$entity->id] = ['id' => $entity->id, 'entity' => $entity->name, 'url' => $entity->url()];
        }
        foreach ($attributes as $attribute) {
            $output[$attribute->entity->id] = ['id' => $attribute->entity->id, 'entity' => $attribute->entity->name, 'url' => $attribute->entity->url()];
        }
        foreach ($posts as $post) {
            $output[$post->entity->id] = ['id' => $post->entity->id, 'entity' => $post->entity->name, 'url' => $post->entity->url()];
        }
        foreach ($questElements as $questElement) {
            $output[$questElement->quest->entity->id] = ['id' => $questElement->quest->entity->id, 'entity' => $questElement->quest->name, 'url' => $questElement->quest->entity->url()];
        }
        foreach ($timelineElements as $timelineElement) {
            $output[$timelineElement->timeline->entity->id] = ['id' => $timelineElement->timeline->entity->id, 'entity' => $$timelineElement->timeline->entity->name, 'url' => $timelineElement->timeline->entity->url()];
        }

        return $output;
    }
}
