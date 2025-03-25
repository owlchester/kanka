<?php

namespace App\Traits;

use App\Datagrids\Bulks\Bulk;
use App\Datagrids\Bulks\DefaultBulk;
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

        if ($modelClass !== null) {
            $bulkClass = 'App\Datagrids\Bulks\\' . Str::studly(Str::singular($modelClass->getTable())) . 'Bulk';
        } else {
            // @phpstan-ignore-next-line
            $model = new $this->model;
            $bulkClass = 'App\Datagrids\Bulks\\' . Str::studly(Str::singular($model->getTable())) . 'Bulk';
        }

        if (class_exists($bulkClass)) {
            return new $bulkClass;
        }

        return new DefaultBulk;
    }
}
