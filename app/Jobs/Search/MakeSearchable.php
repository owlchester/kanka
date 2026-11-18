<?php

namespace App\Jobs\Search;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Jobs\MakeSearchable as ScoutMakeSearchable;

class MakeSearchable extends ScoutMakeSearchable
{
    /** @param Collection<int, Model> $models */
    public function __construct($models)
    {
        // An entity's child can change type before the job runs. Indexing only needs entity fields.
        if ($models->first() instanceof Entity) {
            $models = $models->map->withoutRelations();
        }

        parent::__construct($models);
    }
}
