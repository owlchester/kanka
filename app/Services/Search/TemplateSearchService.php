<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use App\Traits\Search\Orderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TemplateSearchService
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;
    use Orderable;

    protected Builder $query;

    public function search(): array
    {
        $term = mb_trim($this->request->get('q') ?? '');
        $excludes = $this->request->has('exclude') ? $this->request->get('exclude') : null;

        $with = ['image', 'entityType'];
        $this->query = Entity::inTypes($this->entityType->id);
        if (! empty($excludes)) {
            $this->query->whereNotIn('id', [$excludes]);
        }
        if ($this->entityType->isStandard()) {
            $with[] = Str::camel($this->entityType->code);
        }
        $this->query->with($with);
        $this->order($term);

        $entities = $this->query
            ->template() //@phpstan-ignore-line
            ->limit(10)
            ->get();

        $list = [];
        /** @var Entity $entity */
        foreach ($entities as $entity) {
            if ($this->entityType->isStandard() && empty($entity->{$this->entityType->code})) {
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
