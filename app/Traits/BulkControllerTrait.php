<?php

namespace App\Traits;

use App\Datagrids\Bulks\Bulk;
use App\Datagrids\Bulks\BulkResolver;
use App\Models\Bookmark;
use App\Models\MiscModel;
use App\Models\Relation;
use Illuminate\Support\Str;

trait BulkControllerTrait
{
    /**
     * Get the Bulk model of an entity
     */
    protected function bulkModel(MiscModel|Relation|Bookmark|null $modelClass = null): Bulk
    {
        if (isset($this->bulk) && ! empty($this->bulk)) {
            return new $this->bulk;
        }

        // @phpstan-ignore-next-line
        $model = $modelClass ?? new $this->model;

        return app(BulkResolver::class)->for(Str::singular($model->getTable()));
    }
}
