<?php

namespace App\Traits\Search;

use Illuminate\Support\Str;

trait Orderable
{
    protected function order(?string $term): void
    {
        if (empty($term)) {
            $this->query->orderBy('updated_at', 'DESC');
        } else {
            if (Str::startsWith($term, '=')) {
                $this->query->where('name', mb_ltrim($term, '='));
            } else {
                $this->query->where('name', 'like', "%{$term}%");
            }
        }
    }
}
