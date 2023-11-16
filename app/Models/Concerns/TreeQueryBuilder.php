<?php

namespace App\Models\Concerns;

use Kalnoy\Nestedset\QueryBuilder;

class TreeQueryBuilder extends QueryBuilder
{
    public function fixCampaignTree(int $campaign, $root = null)
    {
        $columns = [
            $this->model->getKeyName(),
            $this->model->getParentIdName(),
            $this->model->getLftName(),
            $this->model->getRgtName(),
        ];

        $dictionary = $this->model
            ->newNestedSetQuery()
            ->when($root, function (self $query) use ($root) {
                return $query->whereDescendantOf($root);
            })
            ->where('campaign_id', $campaign)
            ->defaultOrder()
            ->get($columns)
            ->groupBy($this->model->getParentIdName())
            ->all();

        return $this->fixNodes($dictionary, $root);
    }
}
