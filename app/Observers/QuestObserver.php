<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\MiscModel;

class QuestObserver extends MiscObserver
{
    /**
     */
    public function created(MiscModel $model)
    {
        parent::created($model);

        // Copy eras from timeline
        if (request()->has('copy_elements') && request()->filled('copy_elements')) {
            $sourceId = request()->post('copy_source_id');

            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            if ($source->isQuest()) {
                foreach ($source->quest->elements as $sub) {
                    $newSub = $sub->replicate();
                    $newSub->quest_id = $model->id;
                    $newSub->save();
                }
            }
        }
    }
}
