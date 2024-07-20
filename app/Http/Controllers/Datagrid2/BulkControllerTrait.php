<?php

namespace App\Http\Controllers\Datagrid2;

use App\Models\MapGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait BulkControllerTrait
{
    /**
     * List of valid bulk actions.
     * @return string[]
     */
    public function validBulkActions(array $values = ['delete', 'edit', 'patch']): array
    {
        return $values;
    }

    public function bulkProcess(Request $request, string $className): int
    {
        $action = $request->get('action');
        $models = $request->get('model');

        $count = 0;
        $patch = $request->except('models', 'action');
        if ($action === 'patch') {
            // Clean up the request. Skip nulls
            foreach ($patch as $field => $value) {
                if (null !== $value) {
                    continue;
                }
                unset($patch[$field]);
            }
        }
        foreach ($models as $id) {
            /** @var mixed|MapGroup|Model|null $modelClass */
            $modelClass = new $className();
            $model = $modelClass->find($id);
            if (empty($model)) {
                continue;
            }

            if ($action === 'delete') {
                $model->delete();
                $count++;
            } elseif ($action === 'patch') {
                $model->patch($patch);
                $count++;
            }
        }

        return $count;
    }

    public function bulkBatch(string $route, string $view, array $models, mixed $model = null)
    {
        return view('layouts.datagrid.bulks.update')
            ->with('campaign', $this->campaign)
            ->with('route', $route)
            ->with('view', $view)
            ->with('models', $models)
            ->with('model', $model);
    }
}
