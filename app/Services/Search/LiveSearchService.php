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
        if ($this->request->filled('with-family')) {
            $with[] = 'character';
            $with[] = 'character.families';
        }
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
            ->limit(10)
            ->get();

        $list = [];
        $child = Str::camel($this->entityType->code);
        /** @var Entity $entity */
        foreach ($entities as $entity) {
            if ($this->entityType->isStandard() && empty($entity->{$child})) {
                continue;
            }
            $format = [
                'id' => $this->entityType->isCustom() ? $entity->id : $entity->{$child}->id,
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'text' => $entity->name,
            ];
            if ($entity->isTag() && $entity->tag->hasColour()) {
                $format['colour'] = $entity->tag->colourClass();
            }
            $format['image'] = Avatar::entity($entity)->fallback()->size(40)->thumbnail();
            $format['url'] = $entity->url();

            if ($this->request->filled('with-family')) {
                $families = $entity->character->families->pluck('name')->toarray();
                if (! empty($families)) {
                    $format['text'] .= ' (' . implode(', ', $families) . ')';
                }
            }

            $list[] = $format;
        }

        return $list;
    }
}
