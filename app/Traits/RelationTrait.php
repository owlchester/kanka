<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait RelationTrait
{
    public function createRelation(Model $model)
    {
        if (request()->has('two_way')) {

            // Make sure we're not creating an infinite loop
            // Create reverse
            $reverse = new $model;
            $reverse = $reverse
                ->where([
                    'second_id' => $model->first_id,
                    'first_id' => $model->second_id,
                    'relation' => $model->relation,
                ])
                ->first();
            if (empty($reverse)) {
                // Create reverse
                $reverse = new $model;
                $reverse->create([
                    'first_id' => $model->second_id,
                    'second_id' => $model->first_id,
                    'relation' => $model->relation,
                ]);
            }
        }
    }
}
