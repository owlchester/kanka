<?php

namespace App\Services\Search;

use App\Models\Attribute;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\RequestAware;

class AttributeSearchService
{
    use CampaignAware;
    use RequestAware;
    use EntityAware;

    public function find(): array
    {
        $term = mb_trim($this->request->get('q') ?? '');
        $attributes = $this->entity->attributes()
            ->whereLike('name', '%' . $term . '%')
            ->get();
        $results = [];
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            $results[] = [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'value' => $attribute->value,
            ];
        }
        return $results;
    }
}
