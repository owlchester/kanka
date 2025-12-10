<?php

namespace App\Services\Campaign\Connections;

use App\Facades\Avatar;
use App\Http\Resources\Web\EntityResource;
use App\Models\Entity;
use App\Models\Relation;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

class WebService
{
    use CampaignAware;
    use UserAware;

    protected array $entities = [];
    protected array $parsedEntities = [];
    protected array $nodes = [];

    protected Collection $mirrored;

    public function build(): array
    {
        $this->mirrored = new Collection();
        $this->loadConnections();
        return ['entities' => $this->entities, 'nodes' => $this->nodes];
    }

    protected function loadConnections(): void
    {
        $query = Relation::preparedWith();
        if (!$this->campaign->boosted()) {
            $query->limit(config('limits.campaigns.web'))->latest();
        }
        $connections = $query->get();
        foreach ($connections as $connection) {
            $this->parseConnection($connection);
        }
    }

    protected function parseConnection(Relation $connection): void
    {
        $this->addEntity($connection->target);
        $this->addEntity($connection->owner);
        $this->addNode($connection);
    }

    protected function addEntity(Entity $entity): void
    {
        if (in_array($entity->id, $this->parsedEntities)) {
            return;
        }
        $this->entities[$entity->id] = (new EntityResource($entity))->campaign($this->campaign);

    }

    protected function addNode(Relation $connection): void
    {
        // Don't add mirrored relations
        $mirrorKey = $connection->mirror_id . '-' . $connection->id;
        if ($connection->isMirrored() and $this->mirrored->has($mirrorKey)) {
            return;
        }

        $node = [
            'id' => $connection->id,
            'source' => $connection->owner_id,
            'target' => $connection->target_id,
            'text' => $connection->relation,
            'colour' => $connection->colour,
            'attitude' => $connection->attitude,
            'type' => 'entity-relation',
            'is_mirrored' => $connection->isMirrored(),
            'shape' => $connection->isMirrored() && $connection->mirror && $connection->relation == $connection->mirror->relation ? 'none' : 'triangle',
        ];
        if (isset($this->user) && $this->user->can('update', $connection->owner)) {
            $node['url'] = route('entities.relations.edit', [
                'campaign' => $this->campaign,
                'entity' => $connection->owner_id,
                'relation' => $connection,
                'from' => 'web',
            ]);
        }
        $this->nodes[] = $node;


        if ($connection->isMirrored() && $connection->mirror && $connection->relation && $connection->relation == $connection->mirror->relation) {
            $this->mirrored->put($connection->id . '-' . $connection->mirror_id, true);
        }
    }
}
