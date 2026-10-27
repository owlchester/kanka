<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use App\Traits\Search\Orderable;
use Illuminate\Database\Eloquent\Builder;

class LiveSearchService
{
    use CampaignAware;
    use EntityTypeAware;
    use Orderable;
    use RequestAware;

    protected Builder $query;

    public function search(): array
    {
        $term = mb_trim($this->request->get('q') ?? '');
        $excludes = $this->request->has('exclude') ? $this->request->get('exclude') : null;

        $with = ['image', 'entityType'];
        $withParent = $this->request->filled('with-parent') && $this->entityType->id === config('entities.ids.ability');
        if ($withParent) {
            $with[] = 'parent';
        }
        if ($this->request->filled('with-family')) {
            $with['child'] = fn ($child) => $child->morphWith([
                Character::class => ['families.entity'],
            ]);
        }
        $this->query = Entity::inTypes($this->entityType->id);
        if (! empty($excludes)) {
            $this->query->whereNotIn('id', [$excludes]);
        }
        if ($this->entityType->isStandard() && ! isset($with['child'])) {
            $with[] = 'child';
        }
        $this->query->with($with);
        $this->order($term);
        $entities = $this->query
            ->limit(10)
            ->get();

        $onlyEntity = $this->request->filled('entity');

        $list = [];
        /** @var Entity $entity */
        foreach ($entities as $entity) {
            $child = $entity->child;
            $child?->setRelation('entity', $entity);
            if ($this->entityType->isStandard() && $child === null) {
                continue;
            }
            $format = [
                'id' => $this->entityType->isCustom() || $onlyEntity ? $entity->id : $child->id,
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'text' => $entity->name,
            ];
            if ($withParent && $entity->parent) {
                $format['text'] .= ' (' . $entity->parent->name . ')';
            }
            if ($child instanceof Tag && $child->hasColour()) {
                $format['colour'] = $child->colour;
                $format['colour_style'] = $child->colourStyle();
            }
            $format['image'] = Avatar::entity($entity)->fallback()->size(40)->thumbnail();
            $format['url'] = $entity->url();

            if ($this->request->filled('with-family') && $child instanceof Character) {
                $families = $child->families->pluck('name')->toArray();
                if (! empty($families)) {
                    $format['text'] .= ' (' . implode(', ', $families) . ')';
                }
            }

            $list[] = $format;
        }

        return $list;
    }
}
