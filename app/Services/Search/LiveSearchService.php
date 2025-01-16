<?php

namespace App\Services\Search;

use App\Facades\Avatar;
use App\Models\Character;
use App\Models\MiscModel;
use App\Models\Tag;
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
        $excludes = $this->request->has('exclude') ? [$this->request->get('exclude')] : [];

        /** @var MiscModel|Character|Tag $modelClass */
        $modelClass = $this->entityType->getClass();

        $with = ['entity', 'entity.image', 'entity.entityType'];
        if ($this->request->filled('with-family')) {
            $with[] = 'families';
        }

        if (empty($term)) {
            $models = $modelClass
                ->with($with)
                ->has('entity')
                ->whereNotIn('id', $excludes)
                ->limit(10)
                ->orderBy('updated_at', 'DESC')
                ->get();
        } else {
            $models = $modelClass
                ->with($with)
                ->has('entity')
                ->whereNotIn('id', $excludes);
            // Exact match
            if (Str::startsWith($term, '=')) {
                $models->where('name', mb_ltrim($term, '='));
            } else {
                $models->where('name', 'like', "%{$term}%");
            }
            $models = $models
                ->limit(10)
                ->get();
        }

        $list = [];
        /** @var MiscModel $model */
        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->name,
            ];
            // @phpstan-ignore-next-line
            if ($modelClass instanceof Tag && $model->hasColour()) {
                // @phpstan-ignore-next-line
                $format['colour'] = $model->colourClass();
            }
            if (method_exists($model->entity, 'thumbnail')) {
                $format['image'] = Avatar::entity($model->entity)->fallback()->size(40)->thumbnail();
            }

            if ($this->request->filled('with-family')) {
                // @phpstan-ignore-next-line
                $families = $model->families->pluck('name')->toarray();
                if (!empty($families)) {
                    $format['text'] .= ' (' . implode(', ', $families) . ')';
                }
            }

            $list[] = $format;
        }
        return $list;
    }
}
