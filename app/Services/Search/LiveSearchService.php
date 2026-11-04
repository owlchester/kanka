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
        $withFamily = $this->request->filled('with-family') && $this->entityType->id === config('entities.ids.character');
        $withChild = $withFamily || $this->entityType->code === 'tag';
        if ($withFamily) {
            $with['child'] = fn ($child) => $child->morphWith([
                Character::class => ['families.entity'],
            ]);
        } elseif ($withChild) {
            $with[] = 'child';
        }
        $this->query = Entity::inTypes($this->entityType->id);
        if ($this->entityType->isStandard()) {
            $this->query->whereHasMorph('child', $this->entityType->getMiscClass()::class);
        }
        if (! empty($excludes)) {
            $this->query->whereNotIn('id', [$excludes]);
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
            $child = $withChild ? $entity->child : null;
            $format = [
                'id' => $this->entityType->isCustom() || $onlyEntity ? $entity->id : $entity->entity_id,
                'entity_id' => $entity->id,
                'name' => $entity->name,
                'text' => $entity->name,
            ];
            if ($withParent && $entity->parent) {
                $format['text'] .= ' (' . $entity->parent->name . ')';
            }
            if ($this->entityType->code === 'tag' && $child instanceof Tag && $child->hasColour()) {
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
