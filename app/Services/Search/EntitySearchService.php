<?php

namespace App\Services\Search;

use App\Models\Entity;
use App\Models\Attribute;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Models\Post;
use App\Traits\CampaignAware;
use Meilisearch\Client;

class EntitySearchService
{
    use CampaignAware;


    /**
     * Send search request
     */
    public function search(string $term = null): array
    {
        $client = new Client('http://meilisearch:7700', 'password');
        $client->getKeys();
        $ids = [];
        $results = $client->index('entities')->search($term, ['filter' => 'campaign_id = ' . $this->campaign->id, 'attributesToRetrieve' => ['id', 'entity_id', 'type'], 'limit' => 20])->getHits();
        $attributeIds = [];
        $timelineElementIds = [];
        $postIds = [];
        $questElementIds = [];

        foreach ($results as $result) {
            if ($result['type'] == 'quest_element') {
                $id = mb_substr($result['id'], -1, mb_strrpos($result['id'], '_'));
                $questElementIds[$result['entity_id']] = $id;
            //dd($result);
            } elseif ($result['type'] == 'timeline_element') {
                $id = mb_substr($result['id'], -1, mb_strrpos($result['id'], '_'));
                $timelineElementIds[$result['entity_id']] = $id;
            //dd($result);
            } elseif ($result['type'] == 'post') {
                $id = mb_substr($result['id'], -1, mb_strrpos($result['id'], '_'));
                $postIds[$result['entity_id']] = $id;
            //dd($result);
            } elseif ($result['type'] == 'attribute') {
                $id = mb_substr($result['id'], -1, mb_strrpos($result['id'], '_'));
                $attributeIds[$result['entity_id']] = $id;
            //dd($result);
            } else {
                $ids[$result['entity_id']] = $result['entity_id'];
            }
        }
        //If the search also threw the entity as a possible result dont bother loading the other models
        $attributeIds = array_diff_key($attributeIds, $ids);
        $timelineElementIds = array_diff_key($timelineElementIds, $ids);
        $questElementIds = array_diff_key($questElementIds, $ids);
        $postIds = array_diff_key($postIds, $ids);

        $posts = Post::whereIn('id', $postIds)->get();
        $attributes = Attribute::with('entity')->has('entity')->whereIn('id', $attributeIds)->get();
        $questElements = QuestElement::with(['quest', 'quest.entity'])->has('quest')->has('quest')->whereIn('id', $questElementIds)->get();
        $timelineElements = TimelineElement::with(['timeline', 'timeline.entity'])->has('timeline')->whereIn('id', $timelineElementIds)->get();

        $entities = Entity::whereIn('id', $ids)->get();
        foreach ($entities as $entity) {
            $output[$entity->id] = ['id' => $entity->id, 'entity' => $entity->name, 'url' => $entity->url()];
        }
        foreach ($attributes as $attribute) {
            $output[$attribute->entity->id] = ['id' => $attribute->entity->id, 'entity' => $attribute->entity->name, 'url' => $attribute->entity->url()];
        }
        foreach ($posts as $post) {
            $output[$post->entity->id] = ['id' => $post->entity->id, 'entity' => $post->entity->name, 'url' => $post->url()];
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
