<?php

namespace App\Traits\Search;

use Illuminate\Support\Str;

trait Orderable
{
    protected function order(?string $term): void
    {
        $table = $this->query->getModel()->getTable();

        if (empty($term)) {
            $this->query->orderBy($table . '.updated_at', 'desc');
        } else {
            if (Str::startsWith($term, '=')) {
                $this->query->where($table . '.name', mb_ltrim($term, '='));
            } else {
                $this->query->where($table . '.name', 'like', "%{$term}%");
            }
        }
    }
}
