<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use Illuminate\Support\Str;

class TemplateSearchService
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;

    public function search(): array
    {
        $term = mb_trim($this->request->get('q') ?? '');
        $excludes = $this->request->has('exclude') ? $this->request->get('exclude') : null;

        $with = ['image', 'entityType'];
        $query = Entity::inTypes($this->entityType->id);
        if (! empty($excludes)) {
            $query->whereNotIn('id', [$excludes]);
        }
        if (! $this->entityType->isSpecial()) {
            $with[] = Str::camel($this->entityType->code);
        }
        $query->with($with);

        if (empty($term)) {
            $query->orderBy('updated_at', 'DESC');
        } else {
            // Exact match
            if (Str::startsWith($term, '=')) {
                $query->where('name', mb_ltrim($term, '='));
            } else {
                $query->where('name', 'like', "%{$term}%");
            }
        }
        $entities = $query
            ->template()
            ->limit(10)
            ->get();

        $list = [];
        /** @var Entity $entity */
        foreach ($entities as $entity) {
            if (! $this->entityType->isSpecial() && empty($entity->{$this->entityType->code})) {
                continue;
            }
            $format = [
                'id' => $entity->id,
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'text' => $entity->name,
            ];
            $format['image'] = Avatar::entity($entity)->fallback()->size(40)->thumbnail();
            $format['url'] = $entity->url();

            $list[] = $format;
        }

        return $list;
    }
}
