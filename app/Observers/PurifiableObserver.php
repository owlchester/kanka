<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class PurifiableObserver
{
    use PurifiableTrait;

    public function saving(Model $model): void
    {
        // @phpstan-ignore-next-line
        $fields = $model->getPurifiableFields();
        foreach ($fields as $field) {
            $model->{$field} = $this->purify(
                $model->{$field}
            );
        }
    }

}
