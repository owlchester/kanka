<?php


namespace App\Traits;


use App\Datagrids\Bulks\Bulk;
use App\Datagrids\Bulks\DefaultBulk;
use App\Models\MiscModel;
use Illuminate\Support\Str;

trait BulkControllerTrait
{
    /**
     * Get the Bulk model of an entity
     * @param null $model
     * @return Bulk
     */
    protected function bulkModel($modelClass = null): Bulk
    {
        if (isset($this->bulk) && !empty($this->bulk)) {
            return new $this->bulk;
        }

        if ($modelClass) {
            $bulkClass = 'App\Datagrids\Bulks\\' . Str::studly(Str::singular($modelClass->getTable())) . 'Bulk';
        } else {
            $model = new $this->model;
            $bulkClass = 'App\Datagrids\Bulks\\' . Str::studly(Str::singular($model->getTable())) . 'Bulk';
        }

        if (class_exists($bulkClass)) {
            return new $bulkClass;
        }

        return new DefaultBulk();
    }
}