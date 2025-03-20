<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use Illuminate\Support\Str;

class LiveSearchService
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;

    public function search(): array
    {
        $term = mb_trim($this->request->get('q') ?? '');
        $excludes = $this->request->has('exclude') ? $this->request->get('exclude') : null;

        $with = ['image', 'entityType'];
        if ($this->request->filled('with-family')) {
            $with[] = 'character';
            $with[] = 'character.families';
        }
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
            ->limit(10)
            ->get();

        $list = [];
        /** @var Entity $entity */
        foreach ($entities as $entity) {
            if (! $this->entityType->isSpecial() && empty($entity->{$this->entityType->code})) {
                continue;
            }
            $format = [
                'id' => $this->entityType->isSpecial() ? $entity->id : $entity->{$this->entityType->code}->id,
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
